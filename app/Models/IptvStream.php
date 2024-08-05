<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptvStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'url',
        'timeshift',
        'http_referrer',
        'user_agent'
    ];
}
