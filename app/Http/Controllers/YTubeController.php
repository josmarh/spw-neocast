<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\YtubeService;
use App\Jobs\YoutubeToMP4;
use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            'webhook'       => URL::to('media/webhook')
        ];

        dispatch(new YoutubeToMP4($data));

        return response([
            'message' => 'Your video would be added to your collections shortly.'
        ]);
    }
}
