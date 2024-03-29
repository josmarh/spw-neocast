<?php

namespace App\Services;

class AiVideoCreator
{
    private $apikey;

    public function __construct()
    {
        $this->apikey = config('services.yepic.key');
    }

    public function create()
    {
        
    }
}