<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_hash', 'video_id', 'views'
    ];
}
