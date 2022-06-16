<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Channels;
use App\Models\FileUploads;

class ChannelPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_hash',
        'video_id',
        'video_thumbnail',
        'views'
    ];

    public function channels()
    {
        return $this->belongsTo(Channels::class, 'channel_hash', 'channel_hash');
    }

    public function videos()
    {
        return $this->belongsTo(FileUploads::class, 'video_id', 'id');
    }
}
