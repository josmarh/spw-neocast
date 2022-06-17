<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ChannelPlaylist;

class FileUploads extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_hash',
        'file_size',
        'file_type',
        'media_length',
        'tags',
        'external_video_link',
        'upload_types',
        'user_id',
        'vhash',
        'thumbnail',
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
