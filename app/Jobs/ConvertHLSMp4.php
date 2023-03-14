<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Helpers;
use App\Models\FileUploads;
use App\Models\ChannelPlaylist;
use App\Models\LivestreamVideos;

class ConvertHLSMp4 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hlsInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hlsInfo)
    {
        $this->hlsInfo = $hlsInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $helpers = new Helpers();

        $relativePath = $helpers->convertm3u8($this->hlsInfo['link']);
        $thumbnail = $helpers->generateThumbnail($relativePath);
        $linkArr = explode('/', $this->hlsInfo['link']);
        $arrLen = count($linkArr) -1;
        $fileType = explode('.', $linkArr[$arrLen]);
        $fileSize = filesize($relativePath);
        $duration = $helpers->getDuration($relativePath);

        $video = FileUploads::create([
            'file_name' => $linkArr[$arrLen],
            'file_hash' => $relativePath,
            'file_size' => $fileSize,
            'file_type' => $this->hlsInfo['fileType'],
            'media_length' => $duration['duration'],
            'duration_seconds' => $duration['durationInSec'],
            'upload_types' => $this->hlsInfo['uploadTypes'],
            'vhash' => $helpers->generateToken(),
            'thumbnail' => $thumbnail,
            'external_video_link' => $this->hlsInfo['link'],
            'user_id' => $this->hlsInfo['userId']
        ]);

        if($this->hlsInfo['jobOwner'] == 'liveStream') {
            // save to livestream videos
            if($video){
                LivestreamVideos::create([
                    'lhash' => $this->hlsInfo['lhash'],
                    'video_id' => $video->id,
                ]);
            }

            // save to channel playlist if channel isset
            if(count($this->hlsInfo['channels']) > 0) {
                foreach ($this->hlsInfo['channels'] as $ch) {
                    ChannelPlaylist::create([
                        'channel_hash' => $ch->channel_hash,
                        'video_id' => $video->id,
                        'video_thumbnail' => $thumbnail,
                    ]);
                }
            }
        }
    }
}
