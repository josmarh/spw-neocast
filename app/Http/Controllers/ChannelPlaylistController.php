<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Http\Resources\ContentResource;
use App\Http\Resources\PlaylistResource;

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

    public function playlistVidoes($cId)
    {
        $playlist = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash','cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->whereIn('file_uploads.id', function($query)use($cId){
                $query->select('video_id')
                    ->from('channel_playlists');
            })
            ->where('cp.channel_hash', $cId)
            ->orderBy('file_uploads.created_at', 'desc')
            ->get();
 
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

        return response([
            'message' => 'Videos added successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }

    public function deleteVideo($cpId)
    {
        $content = ChannelPlaylist::findOrFail($cpId);

        $content->delete();

        return response([
            'message' => 'Video removed from list.',
            'status' => 'success',
            'status_code' => 204
        ]);
    }
}
