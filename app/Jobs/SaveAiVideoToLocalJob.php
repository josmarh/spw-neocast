<?php

namespace App\Jobs;

use App\Models\FileUploads;
use App\Helpers;
use App\Services\FileHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SaveAiVideoToLocalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $video
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Started running SaveAiVideoToLocalJob... ');

        $dir = 'uploads/';
        $videoUrlArr = explode('.', $this->video['videoUrl']);
        $videoUrlCnt = count($videoUrlArr) -1;
        $filename = $this->video['videoId'].'.'.$videoUrlArr[$videoUrlCnt];
        
        // Save video on server
        $filePath = FileHandler::saveFromUrl($this->video['videoUrl'], $dir, $filename);
        // Get video thumbnail, size, mimetype, duration, durationInSec
        Log::info('Video uploaded... ');

        $helpers = new Helpers();
        $thumbnail = $helpers->generateThumbnail($filePath);
        $duration = $helpers->getDuration($filePath);
        $size = $helpers->size($filePath);
        $mimetype = $helpers->mimetype($filePath);

        // Save to DB
        FileUploads::where('ai_video', $this->video['videoId'])
            ->update([
                'file_name' => $filename,
                'file_hash' => $filePath,
                'file_size' => $size,
                'file_type' => $mimetype,
                'media_length'     => $duration['duration'],
                'duration_seconds' => $duration['durationInSec'],
                'thumbnail' => $thumbnail,
                'external_video_link' => $this->video['videoUrl'],
                'ai_video_status' => 'completed'
            ]);
        Log::info('Video info saved... ');
        Log::info('Completed running SaveAiVideoToLocalJob... ');
    }
}
