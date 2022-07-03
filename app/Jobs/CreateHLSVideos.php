<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateHLSVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
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
        shell_exec('rm '.$this->streamInfo['streamPath'].'*.ts; rm '.$this->streamInfo['streamPath'].'.m3u8');
        shell_exec('cd '.$this->streamInfo['filePath']. '; C:\ffmpeg\bin\ffmpeg.exe -re -f concat -i '.$this->streamInfo['fileName'].' -b:v 1M -g 60 -hls_time 10 -hls_list_size 0 -hls_segment_size 500000 '.$this->streamInfo['streamPath'].'.m3u8');
    }
}
