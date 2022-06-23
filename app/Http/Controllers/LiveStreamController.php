<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\LiveStreamResource;
use App\Models\LiveStream;

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

        return new LiveStreamResource($liveStream);
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
    }
}
