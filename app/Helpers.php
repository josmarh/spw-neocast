<?php

namespace App;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\FileUploads;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

class Helpers
{
    public function getDuration($file)
    {
        $file = explode('/', $file);
        $media = FFMpeg::fromDisk('video')->open($file[1]);

        $durationInSec = $media->getDurationInSeconds();

        $duration = gmdate("H:i:s", $durationInSec);

        if (explode(':', $duration)[0] == '00') {
            $duration = gmdate("i:s", $durationInSec);
        }

        $durations = [
            'duration' => $duration,
            'durationInSec' => $durationInSec,
        ];

        return $durations;
    }

    public function generateThumbnail($filePath)
    {
        $file = explode('/', $filePath);
        $thumbnail = explode('.', $file[1])[0].'.png';

        FFMpeg::fromDisk('video')
            ->open($file[1])
            ->getFrameFromString('00:00:01.01')
            ->export()
            ->toDisk('thumnail')
            ->save($thumbnail);

        return 'video_thumbnail/'.$thumbnail;
    }

    public function convertm3u8($file)
    {
        $dir = 'uploads/';
        $video = $this->generateToken().'.mp4';
        $absolutePath = public_path($dir) . $video;
        $relativePath = $dir . $video;

        try {

            shell_exec('C:\ffmpeg\bin\ffmpeg.exe -i "'.$file.'" -bsf:a aac_adtstoasc -vcodec copy -c copy -crf 50 '.$relativePath);

        } catch (\Throwable $th) {
            
            throw $th;
        }

        return $relativePath;
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
            $file = base64_decode($file);

            if($file === false) {
                throw new Exception("base64_decode failed");
            }
        } else {
            throw new Exception("Did not match data URI with file data");
        }

        $dir = 'uploads/';
        $fileHash = $this->generateToken() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(16));
    }
}