<?php

namespace App\Models;

use App\Models\User;
use App\Models\ChannelPlaylist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_hash',
        'file_size',
        'file_type',
        'media_length',
        'duration_seconds',
        'tags',
        'external_video_link',
        'upload_types',
        'user_id',
        'vhash',
        'thumbnail',
        'ai_video'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(ChannelPlaylist::class, 'video_id', 'id');
    }
}
