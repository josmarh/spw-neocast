<?php

namespace App\Models;

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
        'tags',
        'external_video_link',
        'upload_types',
        'user_id',
        'vhash',
    ];
}
