<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user();

        return response([
            'contents' => FileUploads::where('user_id', $userId->id)->get()
        ]);
    }
}
