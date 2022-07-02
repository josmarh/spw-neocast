<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\FileUploads;
use App\Models\Channels;
use App\Models\ChannelPlaylist;
use App\Models\ChannelReport;
use App\Http\Resources\ContentResource;
use App\Http\Resources\PlaylistResource;
use App\Jobs\CreateHLSVideos;
use App\Jobs\DeleteHLSVideos;
use Carbon\Carbon;
use URL;
use DB;
use Log;

class ChannelPlaylistController extends Controller
{
    public function videos(Request $request, $chash)
    {
        $user = $request->user();
        // $chash = request()->query('chash');

        $contents = FileUploads::where('user_id', $user->id)
            ->whereNotIn('id', function ($query)use($chash) {
                $query->select('video_id')
                    ->from('channel_playlists')
                    ->where('channel_hash', $chash);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return ContentResource::collection($contents);
    }

    public function playlistVidoes($chash)
    {
        $playlist = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash', 'ch.title', 'cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->join('channels as ch', 'ch.channel_hash', '=', 'cp.channel_hash')
            ->whereIn('file_uploads.id', function($query)use($chash){
                $query->select('video_id')->from('channel_playlists');
            })
            ->where('cp.channel_hash', $chash)
            ->orderBy('file_uploads.created_at', 'desc')
            ->with('videos')
            ->paginate(7);
 
        return PlaylistResource::collection($playlist);
    }

    public function videoStore(Request $request)
    {
        $channelId = $request->channelId;
        $videoIds = $request->videos;

        foreach($videoIds as $vId) {
            ChannelPlaylist::create([
                'channel_hash' => $channelId,
                'video_id' => $vId
            ]);
        }

        // check if channel playlist thumbnail is null
        $channel = ChannelPlaylist::where('channel_hash', $channelId)->orderBy('created_at','asc')->first();
        
        if($channel->video_thumbnail == null){
            $video = FileUploads::findOrFail($videoIds[0]);

            // update playlist with thumbnail
            $channel->update(['video_thumbnail' => $video->thumbnail]);
        }

        // check if channel is linear
        $linearCheck = Channels::where('channel_hash', $channelId)->first();

        if(strpos($linearCheck->channel_type, 'Linear') !== false) {
            $streamInfo = $this->makeStreams($channelId, $linearCheck); 

            dispatch(new CreateHLSVideos($streamInfo))->delay(5);
        }

        return response([
            'message' => 'Videos added successfully',
            'status' => $channel,
            'status_code' => 201
        ]);
    }

    public function deleteVideo($cpId)
    {
        $content = ChannelPlaylist::findOrFail($cpId);

        $report = ChannelReport::where('channel_hash', $content->channel_hash)
            ->where('video_id', $content->video_id)
            ->delete();

        // check if channel is linear and refresh streams
        $linearCheck = Channels::where('channel_hash', $content->channel_hash)->first();
        if(strpos($linearCheck->channel_type, 'Linear') !== false) {
            $streamInfo = $this->makeStreams($content->channel_hash, $linearCheck);

            if($streamInfo['type'] == 'createHLS'){
                dispatch(new CreateHLSVideos($streamInfo))->delay(5);
            } else {
                dispatch(new DeleteHLSVideos($streamInfo))->delay(5);
            }
        }

        $content->delete();

        return response([
            'message' => 'Video removed from list.',
            'status' => 'success',
            'status_code' => 204
        ]);
    }

    public function videoPlayAnalysis(Request $request, $chash)
    {
        $videoUrl = explode('#', $request->videoUrl);
        $host = $request->getSchemeAndHttpHost();
        $relativePath = str_ireplace($host.'/', '', $videoUrl[0]);
        $todate = Carbon::now();

        // check video exists
        $getVideoId = FileUploads::where('file_hash', $relativePath)->first();

        if($getVideoId) {
            // check the video tallies with the channel
            $videoViews = ChannelPlaylist::where('channel_hash', $chash)
                ->where('video_id', $getVideoId->id)
                ->first();

            if($videoViews) {
                ChannelPlaylist::where('channel_hash', $chash)
                    ->where('video_id', $getVideoId->id)
                    ->update([
                        'views' => $videoViews->views + 1
                    ]);
                
                // update report table
                $viewsToday = ChannelReport::where('channel_hash', $chash)
                    ->where('video_id', $getVideoId->id)
                    ->where(DB::raw('date(created_at)'), $todate->toDateString())
                    ->first();
                
                if($viewsToday) {
                    ChannelReport::where('channel_hash', $chash)
                        ->where('video_id', $getVideoId->id)
                        ->where(DB::raw('date(created_at)'), $todate->toDateString())
                        ->update([
                            'views' => $viewsToday->views + 1
                        ]);
                } else {
                    ChannelReport::create([
                        'channel_hash' => $chash,
                        'video_id' => $getVideoId->id,
                        'views' => 1
                    ]);
                }
            
                return response([
                    'message' => 'views added',
                    'status' => 'success',
                    'status_code' => 200
                ]);
            }
        }
    }

    public function makeStreams($channelId, $linearCheck)
    {
        // channel videos
        $videos = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash', 'ch.title', 'cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->join('channels as ch', 'ch.channel_hash', '=', 'cp.channel_hash')
            ->whereIn('file_uploads.id', function($query)use($channelId){
                $query->select('video_id')->from('channel_playlists');
            })
            ->where('cp.channel_hash', $channelId)
            ->orderBy('file_uploads.created_at', 'desc')
            ->get();
        
        if($videos) {
            // delete file if exist and creat new file        
            $dir = 'uploads/';
            $absolutePath = public_path($dir);
            if(File::exists($absolutePath.$channelId.".txt")){
                unlink($absolutePath.$channelId.".txt");
            }

            $channelFile = fopen($absolutePath.$channelId.".txt", "a") or die("Unable to open file!");

            foreach($videos as $i => $video) {
                if($i == count($videos) -1) {
                    fwrite($channelFile, "file ".explode('/', $video->file_hash)[1]);
                }else{
                    fwrite($channelFile, "file ".explode('/', $video->file_hash)[1]."\n");
                }
            }

            fclose($channelFile);

            // send for dispatch: videos url, stream_name
            $streamInfo = [
                'filePath' => $absolutePath,
                'fileName' => $channelId.".txt",
                'streamPath' => '/nginx/channels/'.$linearCheck->stream_name,
                'type' => 'createHLS'
            ];

            return $streamInfo;

        }else {
            // delete all ${channel} .ts .m3u8 
            $dir = 'uploads/';
            $absolutePath = public_path($dir);
            if(File::exists($absolutePath.$channelId.".txt")){
                unlink($absolutePath.$channelId.".txt");
            }

            $streamInfo = [
                'filePath' => '/nginx/channels',
                'fileName' => $linearCheck->stream_name,
                'type' => 'deleteHLS'
            ];

            return $streamInfo;
        }
    }

}
