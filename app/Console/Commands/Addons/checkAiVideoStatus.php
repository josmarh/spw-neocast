<?php

namespace App\Console\Commands\Addons;

use App\Models\FileUploads;
use App\Services\FileHandler;
use App\Services\PipioVideoService;
use App\Helpers;
use App\Jobs\SaveAiVideoToLocalJob;
use Illuminate\Console\Command;
use Log;

class checkAiVideoStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-ai-video-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Started checking video status...');

        $videoId = "abf1937b07da4f749094207aa6088141";
        $pipioVideoService = new PipioVideoService();
        try {
            $videoData = $pipioVideoService->retrieveVideo($videoId);
            Log::debug('Video ID:'.$videoId);
        } catch (\Throwable $th) {
            $this->info('Failed to retrieve video...');
            Log::debug(json_encode([
                'message' => $th->getMessage()
            ]));
            exit(1);
        }
        $this->info('Video status: ' . $videoData['status']);

        if($videoData['status'] == 'Completed'){
            $this->info('Adding video to job queue... ');

            dispatch(new SaveAiVideoToLocalJob([
                'videoUrl' => $videoData['videoUrl'],
                'videoId' => $videoId
            ]));
        }
        $this->info('Completed checking video status...');
    }
}
