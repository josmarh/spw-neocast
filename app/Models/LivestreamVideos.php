<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileUploads;
use App\Models\LiveStream;

class LivestreamVideos extends Model
{
    use HasFactory;

    protected $fillable = ['lhash', 'video_id'];

    public function videos()
    {
        return $this->belongsTo(FileUploads::class, 'video_id', 'id');
    }

    public function live()
    {
        return $this->belongsTo(LiveStream::class, 'lhash', 'lhash');
    }
}
