<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response([
            'contents' => FileUploads::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->contentId;
        $validateContent = FileUploads::findOrFail($id);

        $content = $validateContent->update([
            'file_name' => $request->contentName,
            'tags' => $request->videoTag
        ]);

        return response([
            'contents' => $validateContent,
            'status' => 'Content uploaded successfully'
        ]);
    }
}
