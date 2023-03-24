<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Models\LivestreamVideos;
use App\Helpers;
use Log;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class M3u8ToMp4 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    private $videoInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($videoInfo)
    {
        $this->videoInfo = $videoInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->queueProgress(0);
        $response = Http::post(config('services.youtube.m3u8_converter_api').'/m3u8/convert/v2',[
            'link' => $this->videoInfo['link'],
            'webhook' => !$this->videoInfo['webhook'] ? '' : $this->videoInfo['webhook'],
            'user'    => $this->videoInfo['user_id']
        ]);

        if($response->status() == 201) {
            $this->queueProgress(40);

            $dir = 'uploads/';
            $filename = $response->json()['videoTitle'].'.mp4';
            $absolutePath = public_path($dir . $filename);
            $relativePath = $dir . $filename;

            file_put_contents($absolutePath, file_get_contents($response->json()['downloadPath']));

            $helpers = new Helpers();
            $thumbnail = $helpers->generateThumbnail($relativePath);

            $this->queueProgress(70);
            $video = FileUploads::create([
                'file_name' => $response->json()['videoTitle'],
                'file_hash' => $relativePath,
                'file_size' => $response->json()['fileSize'],
                'file_type' => 'video/mp4',
                'media_length'      => $response->json()['duration'],
                'duration_seconds'  => $response->json()['durationInSec'],
                'upload_types'  => 'external video',
                'vhash'         => $helpers->generateToken(),
                'thumbnail'     => $thumbnail,
                'user_id'       => $this->videoInfo['user_id']
            ]);
            $this->queueProgress(90);

            if($this->videoInfo['jobOwner'] === 'liveStream') {
                // save to livestream videos
                if($video) {
                    LivestreamVideos::create([
                        'lhash' => $this->videoInfo['lhash'],
                        'video_id' => $video->id,
                    ]);
                }

                // save to channel playlist if channel isset
                if(count($this->videoInfo['channels']) > 0) {
                    foreach ($this->videoInfo['channels'] as $ch) {
                        ChannelPlaylist::create([
                            'channel_hash' => $ch->channel_hash,
                            'video_id' => $video->id,
                            'video_thumbnail' => $thumbnail,
                        ]);
                    }
                }
            }

            // send request to delete file on server
            $response = Http::post(config('services.youtube.converter_api').'/mp4/delete/v2',[
                'videoId' => $response->json()['videoTitle']
            ]);
            $this->queueProgress(100);
        } 
    }
}
