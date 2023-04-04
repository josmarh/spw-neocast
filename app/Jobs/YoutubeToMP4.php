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
use App\Helpers;
use Log;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class YoutubeToMP4 implements ShouldQueue
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
        /** convert youtube to mp4
        *   save mp4 to path
        *   get thumbnail from mp4
        *   get other required mp4 info
        *   save
        */
        $this->queueProgress(30);
        $response = Http::post(config('services.youtube.m3u8_converter_api').'/youtube/convert',[
            'videoId' => $this->videoInfo['video_id'],
            'webhook' => $this->videoInfo['webhook'],
            'user'    => $this->videoInfo['user_id'],
            'webhookReferer' => 'YoutubeToMp4',
        ]);

        if($response->ok()) {
            $this->queueProgress(100);
        } 
    }
}
