<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FileUploads;
use Log;
use URL;
use Validator;
use App\Helpers;
use App\Jobs\ConvertHLSMp4;

class UploadsController extends Controller
{
    public function fileUpload(Request $request)
    {
        $data = json_encode($request->all());
        $decodeFile = json_decode($data, true);
        $user = $request->user();
        $helpers = new Helpers();

        foreach($decodeFile['file'] as $f) {
            if (isset($f['url'])) {
                $relativePath = $helpers->extractUrl($f['url']);
                $f['url'] = $relativePath;

                $thumbnail = $helpers->generateThumbnail($relativePath);

                FileUploads::create([
                    'file_name' => $f['name'],
                    'file_hash' => $f['url'],
                    'file_size' => $f['size'],
                    'file_type' => $f['type'],
                    'media_length' => $f['duration'],
                    'duration_seconds' => $f['durationInSec'],
                    'upload_types' => 'hosted video',
                    'vhash' => $helpers->generateToken(),
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

        $helpers = new Helpers();

        $hlsInfo = [
            'link' => $request->link,
            'fileType' => 'video/mp4',
            'uploadTypes' => 'external links',
            'userId' => $user->id,
            'jobOwner' => 'uploads'
        ];

        dispatch(new ConvertHLSMp4($hlsInfo))->delay(2);

        // $relativePath = $helpers->convertm3u8($request->link);
        // $thumbnail = $helpers->generateThumbnail($relativePath);
        // $linkArr = explode('/', $request->link);
        // $arrLen = count($linkArr) -1;

        // $fileType = explode('.', $linkArr[$arrLen]);
        // $fileSize = filesize($relativePath);
        // $duration = $helpers->getDuration($relativePath);

        // FileUploads::create([
        //     'file_name' => $linkArr[$arrLen],
        //     'file_hash' => $relativePath,
        //     'file_size' => $fileSize,
        //     'file_type' => 'video/mp4',
        //     'media_length' => $duration['duration'],
        //     'duration_seconds' => $duration['durationInSec'],
        //     'upload_types' => 'external links',
        //     'vhash' => strtolower(Str::random(32)),
        //     'thumbnail' => $thumbnail,
        //     'external_video_link' => $request->link,
        //     'user_id' => $user->id
        // ]);

        return response([
            'status' => 'File will ready shortly.',
            'status_code' => 201
        ]);
    }
}
