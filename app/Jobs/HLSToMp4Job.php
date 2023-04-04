<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class HLSToMp4Job implements ShouldQueue
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
        $this->queueProgress(30);
        $response = Http::post(config('services.youtube.m3u8_converter_api').'/hls/convert',[
            'link'           => $this->videoInfo['link'],
            'webhook'        => $this->videoInfo['webhook'] ? $this->videoInfo['webhook'] : null,
            'user'           => $this->videoInfo['user_id'],
            'jobOwner'       => $this->videoInfo['jobOwner'],
            'lhash'          => array_key_exists('lhash', $this->videoInfo) ? $this->videoInfo['lhash'] : null,
            'channels'       => array_key_exists('channels', $this->videoInfo) ? json_encode($this->videoInfo['channels']) : null,
            'webhookReferer' => 'M3u8ToMp4',
        ]);

        if($response->ok()) {
            $this->queueProgress(100);
        }
    }
}
