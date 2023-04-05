<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Illuminate\Support\Facades\Http;

class DeleteHLSVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public $streamInfo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($streamInfo)
    {
        $this->streamInfo = $streamInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->queueProgress(20);

        $response = Http::post(config('services.youtube.m3u8_converter_api').'/mp4/convert/hls',[
            'action'   => 'deleteHLS',
            'filePath' => $this->streamInfo['filePath'].'/',
            'fileName' => $this->streamInfo['fileName']
        ]);

        // shell_exec('cd '.$this->streamInfo['filePath']. '; rm '.$this->streamInfo['fileName'].'*.ts; rm '.$this->streamInfo['fileName'].'.m3u8');
        
        $this->queueProgress(100);
    }
}
