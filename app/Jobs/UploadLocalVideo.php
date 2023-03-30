<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\FileUploads;
use Illuminate\Support\Facades\File;
use App\Helpers;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class UploadLocalVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    private $fileInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->queueProgress(0);

        $data = $this->fileInfo['data'];
        $userId = $this->fileInfo['user_id'];

        $decodeFile = json_decode($data, true);
        $helpers = new Helpers();

        foreach($decodeFile['file'] as $key => $f) {
            if (isset($f['url'])) {
                
                $this->queueProgress(50);

                $relativePath = $this->extractUrl($f['url']);
                $thumbnail = $helpers->generateThumbnail($relativePath);
                $f['url'] = $relativePath;

                FileUploads::create([
                    'file_name' => $f['name'],
                    'file_hash' => $f['url'],
                    'file_size' => $f['size'],
                    'file_type' => $f['type'],
                    'media_length'     => $f['duration'],
                    'duration_seconds' => $f['durationInSec'],
                    'upload_types'     => 'hosted video',
                    'vhash'     => bin2hex(random_bytes(16)),
                    'thumbnail' => $thumbnail,
                    'user_id'   => $userId
                ]);
            }else {
                throw new Exception("Video upload failed!");
            }
        }
        $this->queueProgress(100);
    }

    public function extractUrl($file)
    {
        // check if it's a valid base64 string
        if (preg_match('/^data:video\/(\w+);base64,/', $file, $type)
            || preg_match('/^data:audio\/(\w+);base64,/', $file, $type)) {
            // take out the base64 encoded text without mimetype
            $file = substr($file, strpos($file, ',') +1);
            // get file extension 
            $type = strtolower($type[1]);
            $file = str_replace(' ', '+', $file);
            // $file = base64_decode($file);

            // if($file === false) {
            //     throw new Exception("base64_decode failed");
            // }
        } else {
            throw new Exception("Did not match data URI with file data");
        }

        $dir = 'uploads/';
        $fileHash = bin2hex(random_bytes(16)) . '.' . $type;
        $absolutePath = public_path($dir);
        $addPath = public_path($dir . $fileHash);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }

        // file_put_contents($addPath, $file);
        $whandle = fopen($addPath,'w');
        stream_filter_append($whandle,'convert.base64-decode',STREAM_FILTER_WRITE);
        fwrite($whandle,$file);
        fclose($whandle);

        return $relativePath;
    }
}
