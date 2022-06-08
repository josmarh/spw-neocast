<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_hash',
        'video_id',
        'video_thumbnail',
        'views'
    ];
}
