<?php

namespace App;

use Illuminate\Support\Facades\Http;

class YtubeService
{
    public $api;
    public $converterApi;
    private $apiKey;

    public function __construct()
    {
        $this->api = config('services.youtube.api');
        $this->apiKey = config('services.youtube.key');
        $this->converterApi = config('services.youtube.converter_api');
    }

    public function getTrendingVidoes()
    {
        try {
            $response = Http::get($this->api.'/search', [
                'key'   =>  $this->apiKey,
                'part'  =>  'snippet',
                'type'  =>  'video',
                'chart' =>  'mostPopular',
                'maxResults'    =>  '12',
                'videoLicense'  =>  'creativeCommon'
            ]);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        return $response;        
    }

    public function searchVideo($videoId)
    {
        try {
            $response = Http::get($this->api.'/videos', [
                'key'   =>  $this->apiKey,
                'part'  =>  'snippet',
                'id'    =>  $videoId,
            ]);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        return $response;
    }
}