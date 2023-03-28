<?php

namespace App;

use Illuminate\Support\Facades\Http;

class YtubeService
{
    public $api;
    public $converterApi;
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->api = config('services.youtube.api');
        $this->apiKey = $apiKey;
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
                'maxResults'    =>  '20',
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

    public function searchVideoWithKeyword($keyword)
    {
        try {
            $response = Http::get($this->api.'/search', [
                'key' =>  $this->apiKey,
                'q'   =>  $keyword,
                'part'  =>  'snippet',
                'type'  =>  'video',
                'maxResults'    =>  '50',
                'videoLicense'  =>  'creativeCommon'
            ]);
        } catch (Exception $e) {
            throw $e->getMessage();
        }

        return $response;
    }
}