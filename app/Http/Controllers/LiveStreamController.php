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
use App\Helpers;
use App\Jobs\ConvertHLSMp4;
use App\Jobs\HLSToMp4Job;
use App\Jobs\M3u8ToMp4;
use URL;

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

        dispatch(new HLSToMp4Job([
            'link'      => $request->link,
            'user_id'   => $user->id,
            'jobOwner'  => 'liveStream',
            'lhash'     => $request->lhash,
            'channels'  => $request->channel,
            'webhook'   => URL::to('media/webhook')
        ]))->delay(5);

        return response([
            'message' => 'Adding live video to list',
            'latestStreams' => [], //LastestStreamsResource::collection($latestStreams),
            'status_code' => 201,
        ]);
    }
}
