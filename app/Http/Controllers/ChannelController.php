<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Channels;
use App\Http\Resources\ChannelResource;
use App\Http\Controllers\UploadsController;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $channels = Channels::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return ChannelResource::collection($channels);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $relativePath = null;

        if (isset($request->logo)) {
            $relativePath = $this->extractUrl($request->logo);
        }

        Channels::create([
            'title' => $request->title,
            'schedule_duration' => $request->schedule,
            'start_time' => $request->starttime,
            'timezone' => $request->timezone,
            'logo' => $relativePath,
            'logo_link' => $request->logolink,
            'logo_position' => $request->logoposition,
            'color' => $request->color,
            'twitter' => $request->twitter,
            'privacy' => $request->privacy,
            'privacy_domain' => $request->privacydomain,
            'ad_tag_url' => $request->adtagurl,
            'channel_type' => $request->channeltype,
            'channel_hash' => strtolower(Str::random(26)),
            'user_id' => $user->id,
        ]);

        return response([
            'message' => 'File uploaded successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }

    public function update(Request $request, $id)
    {
        $channel = Channels::findOrFail($id);
    }

    private function extractUrl($file)
    {
        // check if it's a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
            // take out the base64 encoded text without mimetype
            $file = substr($file, strpos($file, ',') +1);
            // get file extension 
            $type = strtolower($type[1]);
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);

            if($file === false) {
                throw new Exception("base64_decode failed");
            }
        } else {
            throw new Exception("Did not match data URI with file data");
        }

        $dir = 'channel_logos/';
        $fileHash = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }
}
