<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteHLSVideos implements ShouldQueue
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
        shell_exec('cd '.$this->streamInfo['filePath']. '; rm '.$this->streamInfo['fileName'].'*.ts; rm '.$this->streamInfo['fileName'].'.m3u8');
    }
}
