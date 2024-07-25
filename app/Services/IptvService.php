<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IptvService
{
    const IPTV_URL = 'https://iptv-org.github.io';
    const IPTV_API = self::IPTV_URL.'/api';

    public function getChannels()
    {
        return Http::retry(3, 100)
            ->get(self::IPTV_API.'/channels.json')
            ->throw()
            ->json();
    }

    public function getStreams()
    {
        return Http::retry(3, 100)
            ->get(self::IPTV_API.'/streams.json')
            ->throw()
            ->json();
    }
}