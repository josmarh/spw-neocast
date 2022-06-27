<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\LiveStreamResource;
use App\Http\Resources\LastestStreamsResource;
use App\Http\Controllers\UploadsController;
use App\Models\LiveStream;
use App\Models\LivestreamVideos;
use App\Models\ChannelPlaylist;
use App\Models\FileUploads;
use Carbon\Carbon;

class LiveStreamController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $title = request()->query('title');

        if(isset($title)) {
            $liveStream = LiveStream::where('user_id', $user->id)
                ->where('title', 'like', '%'.$title.'%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $liveStream =  LiveStream::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return LiveStreamResource::collection($liveStream);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = LiveStream::create([
            'title' => $request->title,
            'channels' => json_encode($request->channel),
            'stream_record' => $request->record_stream,
            'broadcast_signal' => $request->bsignal,
            'stream_key' => $request->streamKey,
            'live_status' => $request->liveStatus,
            'lhash' => strtolower(Str::random(32)),
            'user_id' => $user->id
        ]);

        return response([
            'data' => new LiveStreamResource($data),
            'message' => 'success',
            'status_code' => 201,
        ]);      
    }

    public function edit($lhash)
    {
        $liveStream = LiveStream::where('lhash', $lhash)->first();

        // call existing videos associated to this lhash limit 5
        $latestStreams = LivestreamVideos::select('fu.*', 'livestream_videos.lhash', 'livestream_videos.video_id')
            ->join('file_uploads as fu', 'fu.id', '=', 'livestream_videos.video_id')
            ->where('lhash', $lhash)
            ->orderBy('fu.created_at', 'desc')
            ->limit(5)
            ->get();

        return response([
            'data' => new LiveStreamResource($liveStream),
            'latestStreams' => LastestStreamsResource::collection($latestStreams),
            'status_code' => 200
        ]);
    }

    public function update(Request $request, $id)
    {
        $liveStream = LiveStream::findOrFail($id);

        $liveStream->update([
            'title' => $request->title,
            'channels' => json_encode($request->channel),
            'stream_record' => $request->record_stream,
            'broadcast_signal' => $request->bsignal,
            'stream_key' => $request->streamKey,
            'live_status' => $request->liveStatus,
        ]);

        return response([
            'data' => new LiveStreamResource($liveStream),
            'message' => 'success',
            'status_code' => 200,
        ]);
    }

    public function delete($id)
    {
        $LiveStream = LiveStream::findOrFail($id);

        // delete from livestream videos tbl
        LivestreamVideos::where('lhash', $LiveStream->lhash)->delete();

        // delete livestream data
        $LiveStream->delete();

        return response([
            'message' => 'Deleted successfully.',
            'status_code' => 204,
        ]);
    }

    public function storeLiveVideo(Request $request, UploadsController $converter)
    {
        $user = $request->user();
        
        // save to upload table
        $link = $converter->convertm3u8($request->link);
        $thumbnail = $converter->generateThumbnail($link);
        $linkArr = explode('/', $request->link);
        $arrLen = count($linkArr) -1;
        $fileType = explode('.', $linkArr[$arrLen]);
        $fileSize = filesize($link);
        $duration = $converter->getDuration($link);

        $video = FileUploads::create([
            'file_name' => 'Live '. Carbon::now()->toDateTimeString(),
            'file_hash' => $link,
            'file_size' => $fileSize,
            'file_type' => 'video/mp4',
            'media_length' => $duration,
            'upload_types' => 'hosted video',
            'vhash' => strtolower(Str::random(32)),
            'thumbnail' => $thumbnail,
            'external_video_link' => $request->link,
            'user_id' => $user->id
        ]);

        // save to livestream videos
        if($video){
            LivestreamVideos::create([
                'lhash' => $request->lhash,
                'video_id' => $video->id,
            ]);
        }

        // save to channel playlist if channel isset
        $channels = $request->channel;
        
        if(count($channels) > 0) {
            foreach ($channels as $ch) {
                ChannelPlaylist::create([
                    'channel_hash' => $ch->channel_hash,
                    'video_id' => $video->id,
                    'video_thumbnail' => $thumbnail,
                ]);
            }
        }

        // call existing videos associated to this lhash limit 5
        $latestStreams = LivestreamVideos::select('fu.*', 'livestream_videos.lhash', 'livestream_videos.video_id')
            ->join('file_uploads as fu', 'fu.id', '=', 'livestream_videos.video_id')
            ->where('lhash', $request->lhash)
            ->orderBy('fu.created_at', 'desc')
            ->limit(5)
            ->get();

        return response([
            'message' => 'Live video added',
            'latestStreams' => LastestStreamsResource::collection($latestStreams),
            'status_code' => 201,
        ]);
    }
}
