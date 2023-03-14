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

class YoutubeToMP4 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $response = Http::post(config('services.youtube.converter_api').'/mp4/convert',[
            'videoId' => $this->videoInfo['video_id'],
            'webhook' => $this->videoInfo['webhook'],
            'user'    => $this->videoInfo['user_id']
        ]);

        if($response->status() == 201) {
            $dir = 'uploads/';
            $filename = $this->videoInfo['video_id'].'.mp4';
            $absolutePath = public_path($dir . $filename);
            $relativePath = $dir . $filename;

            file_put_contents($absolutePath, file_get_contents($response->json()['downloadPath']));

            $helpers = new Helpers();
            $thumbnail = $helpers->generateThumbnail($relativePath);

            FileUploads::create([
                'file_name' => $this->videoInfo['video_name'],
                'file_hash' => $relativePath,
                'file_size' => $response->json()['fileSize'],
                'file_type' => 'video/mp4',
                'media_length'      => $response->json()['duration'],
                'duration_seconds'  => $response->json()['durationInSec'],
                'upload_types'  => 'hosted video',
                'vhash'         => $helpers->generateToken(),
                'thumbnail'     => $thumbnail,
                'user_id'       => $this->videoInfo['user_id']
            ]);

            // send request to delete file on server
            $response = Http::post(config('services.youtube.converter_api').'/mp4/delete',[
                'videoId' => $this->videoInfo['video_id']
            ]);
        } 
    }
}
