<?php

namespace App\Http\Controllers;

use App\Models\FileUploads;
use App\Helpers;
use App\Jobs\ConvertHLSMp4;
use App\Jobs\M3u8ToMp4;
use App\Jobs\HLSToMp4Job;
use App\Jobs\UploadLocalVideo;
use App\Services\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use URL;
use Validator;

class UploadsController extends Controller
{
    public function fileUpload(FileHandler $fileHandler, Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'url'  => ['required','string'],
            'name' => ['required','string'],
            'type' => ['required','string'],
            'size' => ['required'],
            'calSize' => ['required','string'],
        ]);

        try {
            $file = substr($data['url'], strpos($data['url'], ',') +1);
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);

            $response = $fileHandler->saveFile(
                explode('/', $data['type'])[1],
                $file,
            );
        } catch (\Throwable $th) {
            return response([
                'error' => $th->getMessage()
            ],422);
        }

        FileUploads::create([
            'file_name' => $data['name'],
            'file_hash' => $response['filePath'],
            'file_size' => $data['size'],
            'file_type' => $data['type'],
            'media_length'     => $request->duration,
            'duration_seconds' => $request->durationInSec,
            'upload_types'     => 'hosted video',
            'vhash'     => bin2hex(random_bytes(16)),
            'thumbnail' => $response['thumbnail'],
            'user_id'   => $user->id
        ]);

        return response([
            'status' => 'Upload successful.',
            'status_code' => 201
        ]);
    }

    public function linkUpload(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'link' => 'required|url'
        ]);

        dispatch(new HLSToMp4Job([
            'link'      => $request->link,
            'user_id'   => $user->id,
            'jobOwner'  => 'uploads',
            'webhook'   => URL::to('media/webhook')
        ]))->delay(5);

        return response([
            'status' => 'Video will ready shortly.',
            'status_code' => 201
        ]);
    }
}
