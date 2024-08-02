<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PipioVideoService
{
    private $key;
    public $videoUrl;
    public $assetUrl;

    public function __construct()
    {
        $this->key = config('services.pipio.key');
        $this->videoUrl = config('services.pipio.video_url');
        $this->assetUrl = config('services.pipio.asset_url');
    }

    public function getActors($page, $pageSize)
    {
        $params = [
            'page' => $page,
            'pageSize' => $pageSize
        ];

        return Http::withHeaders([
                'Authorization' => $this->key,
                'Content-Type' => 'application/json'
            ])
            ->withQueryParameters($params)
            ->get($this->assetUrl.'/actor')
            ->throw()
            ->json();
    }

    public function generateVideo($data)
    {
        $payload = [
            'actorId'   => $data['actorId'],
            'language'  => $data['language'],
            'script'    => $data['script'],
        ];

        return Http::withHeaders([
                'Authorization' => $this->key,
                'Content-Type' => 'application/json'
            ])
            ->post($this->videoUrl, $payload)
            ->throw()
            ->json();
    }

    public function retrieveVideo($videoId)
    {
        return Http::withHeaders([
                'Authorization' => $this->key,
                'Content-Type' => 'application/json'
            ])
            ->get($this->videoUrl.'/'.$videoId)
            ->throw()
            ->json();
    }
}