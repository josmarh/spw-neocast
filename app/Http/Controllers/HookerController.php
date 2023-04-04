<?php

namespace App\Http\Controllers;

use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Models\LivestreamVideos;
use App\Helpers;
use Illuminate\Http\Request;
use Log;

class HookerController extends Controller
{
    public function webhook(Request $request)
    {
        $helpers = new Helpers();

        if($request->webhookReferer === 'M3u8ToMp4') {
            $dir = 'uploads/';
            $filename = $request->videoTitle.'.mp4';
            $absolutePath = public_path($dir . $filename);
            $relativePath = $dir . $filename;
            $thumbnail = $helpers->generateThumbnail($relativePath);

            $video = FileUploads::create([
                'file_name' => $request->videoTitle,
                'file_hash' => $relativePath,
                'file_size' => $request->fileSize,
                'file_type' => 'video/mp4',
                'media_length'      => $request->duration,
                'duration_seconds'  => $request->durationInSec,
                'upload_types'  => 'external video',
                'vhash'         => $helpers->generateToken(),
                'thumbnail'     => $thumbnail,
                'user_id'       => $request->user
            ]);

            // save to livestream videos
            if($request->jobOwner === 'liveStream') {
                // save to livestream videos
                if($video) {
                    LivestreamVideos::create([
                        'lhash'     => $request->lhash,
                        'video_id'  => $video->id,
                    ]);
                }
                // save to channel playlist
                $channels = json_decode($request->channels);

                if(count($channels) > 0) {
                    foreach ($channels as $ch) {
                        ChannelPlaylist::create([
                            'channel_hash'    => $ch->channel_hash,
                            'video_id'        => $video->id,
                            'video_thumbnail' => $thumbnail,
                        ]);
                    }
                }
            }
        }
    }
}
