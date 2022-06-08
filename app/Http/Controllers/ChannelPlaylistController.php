<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Http\Resources\ContentResource;

class ChannelPlaylistController extends Controller
{
    public function videos(Request $request)
    {
        $user = $request->user();
        $chash = request()->query('chash');

        $contents = FileUploads::where('user_id', $user->id)
            ->whereNotIn('id', function ($query)use($chash) {
                $query->select('video_id')
                    ->from('channel_playlists')
                    ->where('channel_hash', $chash);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return ContentResource::collection($contents);
    }

    public function playlistVidoes()
    {
        
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

        return response([
            'message' => 'Videos added successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }
}
