<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\FileUploads;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Log;
use URL;

class UploadsController extends Controller
{
    public function fileUpload(Request $request)
    {
        $data = json_encode($request->all());
        $decodeFile = json_decode($data, true);
        $user = $request->user();
        
        foreach($decodeFile['file'] as $f) {
            if (isset($f['url'])) {
                $relativePath = $this->extractUrl($f['url']);
                $f['url'] = $relativePath;

                $thumbnail = $this->generateThumbnail($relativePath);

                fileUploads::create([
                    'file_name' => $f['name'],
                    'file_hash' => $f['url'],
                    'file_size' => $f['size'],
                    'file_type' => $f['type'],
                    'media_length' => $f['duration'],
                    'upload_types' => 'hosted video',
                    'vhash' => strtolower(Str::random(26)),
                    'thumbnail' => $thumbnail,
                    'user_id' => $user->id
                ]);
            }else {
                throw new Exception("File upload failed!");
            }
        }

        return response([
            'status' => 'File uploaded successfully',
            'status_code' => 201
        ]);
    }

    public function linkUpload(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'link' => 'required|url'
        ]);

        $relativePath = $this->convertm3u8($request->link);
        $thumbnail = $this->generateThumbnail($relativePath);
        $linkArr = explode('/', $request->link);
        $arrLen = count($linkArr) -1;

        $fileType = explode('.', $linkArr[$arrLen]);
        $fileSize = filesize($relativePath);
        $duration = $this->getDuration($relativePath);

        fileUploads::create([
            'file_name' => $linkArr[$arrLen],
            'file_hash' => $relativePath,
            'file_size' => $fileSize,
            'file_type' => 'video/'.$fileType[1],
            'media_length' => $duration,
            'upload_types' => 'external links',
            'vhash' => strtolower(Str::random(32)),
            'thumbnail' => $thumbnail,
            'external_video_link' => $request->link,
            'user_id' => $user->id
        ]);

        return response([
            'status' => 'File uploaded successfully',
            'status_code' => 201
        ]);
    }

    private function extractUrl($file)
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
        $fileHash = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }

    public function generateThumbnail($filePath)
    {
        $file = explode('/', $filePath);
        $thumbnail = Str::random().'.png';

        FFMpeg::fromDisk('video')
            ->open($file[1])
            ->getFrameFromString('00:00:05.01')
            ->export()
            ->toDisk('thumnail')
            ->save($thumbnail);

        return 'video_thumbnail/'.$thumbnail;
    }

    public function convertm3u8($file)
    {
        $dir = 'uploads/';
        $video = Str::random().'.mp4';
        $relativePath = $dir . $video;

        try {

            shell_exec('C:\ffmpeg\bin\ffmpeg.exe -i "'.$file.'" -bsf:a aac_adtstoasc -vcodec copy -c copy -crf 50 '.$relativePath);

        } catch (\Throwable $th) {
            
            throw $th;
        }

        return $relativePath;
    }

    public function getDuration($file)
    {
        $file = explode('/', $file);
        $media = FFMpeg::fromDisk('video')->open($file[1]);

        $durationInMiliseconds = $media->getDurationInSeconds();

        $duration = gmdate("H:i:s", $durationInMiliseconds);

        if (explode(':', $duration)[0] == '00') {
            $duration = gmdate("i:s", $durationInMiliseconds);
        }

        return $duration;
    }
}
