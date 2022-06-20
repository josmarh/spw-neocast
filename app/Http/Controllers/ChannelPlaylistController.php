<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Models\ChannelReport;
use App\Http\Resources\ContentResource;
use App\Http\Resources\PlaylistResource;
use Carbon\Carbon;
use DB;

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

}
