<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptvCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'channels',
        'playlist',
        'thumbnail'
    ];
}
