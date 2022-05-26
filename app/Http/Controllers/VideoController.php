<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Http\Resources\ContentResource;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $contents = FileUploads::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response([
            'contents' => ContentResource::collection($contents),
            'status' => 'success',
            'status_code' => 200
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->contentId;
        $validateContent = FileUploads::findOrFail($id);

        $validateContent->update([
            'file_name' => $request->contentName,
            'tags' => $request->videoTag
        ]);

        return response([
            'contents' => new ContentResource($validateContent),
            'status' => 'Content uploaded successfully'
        ]);
    }

    public function show(Request $request, $str)
    {
        $content = FileUploads::where('file_hash', 'like', '%'.$str.'%')->first();

        return response([
            'content' => new ContentResource($content),
            'message' => $content ? 'content available' : 'content unavailable',
            'status' => $content ? 200 : 401
        ]);
    }
}
