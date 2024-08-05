<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'timezone',
        'scheduled_at',
        'channel',
        'video_source',
        'scheduled_videos',
        'ai_keyword',
        'ai_content',
        'ai_actor_id',
        'ai_video_id',
        'ai_video_status',
        'status',
        'user_id'
    ];

    public function channelRef()
    {
        return $this->belongsTo(\App\Models\Channels::class, 'channel');
    }
}
