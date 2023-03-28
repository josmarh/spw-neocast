<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\YtubeService;
use App\Jobs\YoutubeToMP4;
use App\Helpers;
use URL;

class YTubeController extends Controller
{
    public function index()
    {
        if (Cache::has('videos')) {
            return Cache::get('videos');
        }

        $youtube = new YtubeService(config('services.youtube.key'));
        $response = $youtube->getTrendingVidoes();

        if(!$response->ok()) {
            return response([
                'error' => $response
            ], 422);
        }

        $videos = Cache::put('videos', $response->json(), now()->addHour(12));

        return Cache::get('videos');
    }

    public function search(Request $request, $videoId)
    {
        $searchType = $request->query('type'); // link or keyword
        $user = User::find($request->user()->id);

        if (!$user->youtube_api_key) {
            return response([
                'error'=>'Please add your youtube API key'
            ],422);
        }

        $youtube = new YtubeService($user->youtube_api_key);

        if($searchType == 'keyword') {
            $response = $youtube->searchVideoWithKeyword($videoId);
        }else {
            $response = $youtube->searchVideo($videoId);
        }
        
        if(!$response->ok()) {
            return response([
                'error' => $response
            ], 422);
        }

        return $response->json();
    }

    public function saveVideo(Request $request)
    {
        $user = $request->user();

        $data = [
            'user_id'       => $user->id,
            'video_id'      => $request->videoId,
            'video_name'    => $request->videoTitle,
            'webhook'       => URL::to('ytube/webhook')
        ];

        dispatch(new YoutubeToMP4($data))->delay(5);

        return response([
            'message' => 'Your video would be added to your collections shortly.'
        ]);
    }

    public function webhook(Request $request)
    {
        $data = $request->all();
        $helpers = new Helpers();

        // add file to path
        // create thumbnail

        FileUploads::create([
            'file_name' => $data['videoTitle'],
            'file_hash' => $relativePath,
            'file_size' => $data['fileSize'],
            'file_type' => 'video/mp4',
            'media_length'      => $data['duration'],
            'duration_seconds'  => $data['durationInSec'],
            'upload_types'  => 'hosted video',
            'vhash'         => $helpers->generateToken(),
            'thumbnail'     => $thumbnail,
            'user_id'       => $data['user']
        ]);

        // send delete file request
        // push notification

    }
}
