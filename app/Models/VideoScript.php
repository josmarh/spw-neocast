<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'content',
        'user_id'
    ];
}
