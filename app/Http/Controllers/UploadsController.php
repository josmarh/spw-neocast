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
use App\Jobs\M3u8ToMp4;
use App\Jobs\HLSToMp4Job;
use App\Jobs\UploadLocalVideo;

class UploadsController extends Controller
{
    public function fileUpload(Request $request)
    {
        $data = json_encode($request->all());
        $user = $request->user();

        dispatch(new UploadLocalVideo([
            'data'    => $data,
            'user_id' => $user->id
        ]))->delay(5);

        return response([
            'status' => 'Video will be ready shortly',
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
