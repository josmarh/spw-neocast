<?php

namespace App\Jobs;

use App\Models\FileUploads;
use App\Helpers;
use App\Services\YoutubeDownload;
use App\Services\YoutubeDownloader;
use App\Services\FileHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use Log;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use pira\YTDL;

class YoutubeToMP4 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public $videoInfo
    )
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Started running YoutubeToMP4... ');

        /** convert youtube to mp4
        *   save mp4 to path
        *   get thumbnail from mp4
        *   get other required mp4 info
        *   save
        */
        
        // $response = Http::post(config('services.youtube.m3u8_converter_api').'/youtube/convert',[
        //     'videoId' => $this->videoInfo['video_id'],
        //     'webhook' => $this->videoInfo['webhook'],
        //     'user'    => $this->videoInfo['user_id'],
        //     'webhookReferer' => 'YoutubeToMp4',
        //     'targetPath' => '/home/tubetargeterapp/hq.tvengager.com/public/uploads/'
        // ]);

        try {
            $ytUrl = 'https://www.youtube.com/watch?v='.$this->videoInfo['video_id'];
            $ytdl = new YTDL($ytUrl);
            
            $ytdl->setQuality('480');
            $response = $ytdl->sendRequest();
            // print_r($response);
            
            if ( isset($response['data']['url'])) {
                $videoUrl = $response['data']['url'];
                $relativePath = 'uploads/'.bin2hex(random_bytes(16)).'.mp4';
                $outputFilePath = public_path($relativePath);
                $videoContent = file_get_contents($videoUrl);

                if ($videoContent === false) {
                    throw new Exception('Failed to download video from URL.');
                }
                file_put_contents($outputFilePath, $videoContent);

                Log::debug("Video saved to $outputFilePath\n");
                $helpers = new Helpers();
                $thumbnail = $helpers->generateThumbnail($relativePath);
                $duration = $helpers->getDuration($relativePath);
                $size = $helpers->size($relativePath);
                $mimetype = $helpers->mimetype($relativePath);

                // Save video
                FileUploads::create([
                    'upload_types' => 'hosted video',
                    'vhash' => bin2hex(random_bytes(16)),
                    'user_id'  => $this->videoInfo['user_id'],
                    'file_name' => $this->videoInfo['video_name'],
                    'file_hash' => $relativePath,
                    'file_size' => $size,
                    'file_type' => $mimetype,
                    'media_length'     => $duration['duration'],
                    'duration_seconds' => $duration['durationInSec'],
                    'thumbnail' => $thumbnail,
                    'external_video_link' => $ytUrl,
                ]);
            } else {
                Log::debug("Failed to retrieve video URL.");
                exit(1);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
