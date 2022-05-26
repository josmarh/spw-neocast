<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'status' => 'Content updated successfully',
            'status_code' => 200,
        ]);
    }

    public function show(Request $request, $str)
    {
        $content = FileUploads::where('file_hash', 'like', '%'.$str.'%')->first();

        return response([
            'content' => new ContentResource($content),
            'message' => $content ? 'Content available' : 'Content unavailable',
            'status_code' => $content ? 200 : 401
        ]);
    }

    public function download($id)
    {
        $content = FileUploads::findOrFail($id);

        $headers = array(
            'Content-Type: video/mp4',
            'Content-Type: video/mpeg',
            'Content-Type: video/ogg',
            'Content-Type: video/x-msvideo',
            'Content-Type: audio/mpeg',
            'Content-Type: audio/ogg',
            'Content-Type: audio/opus',
            'Content-Type: audio/wav',
            'Content-Type: audio/webm',
            'Content-Type: audio/webp',
            'Content-Type: audio/3gpp',
        );

        return response()->download(public_path().'/'.$content->file_hash, $content->file_name, $headers );
    }

    public function delete($id)
    {
        $content = FileUploads::findOrFail($id);

        File::delete(public_path().'/'.$content->file_hash);
        $content->delete();

        return response([
            'message' => 'Content deleted successfully.',
            'status' => 'success',
            'status_code' => 204
        ]);
    }
}
