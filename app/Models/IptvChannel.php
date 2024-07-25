<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptvChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id',
        'name',
        'alt_names',
        'network',
        'owners',
        'country',
        'subdivision',
        'city',
        'broadcast_area',
        'languages',
        'categories',
        'is_nsfw',
        'launched',
        'closed',
        'replaced_by',
        'website',
        'logo'
    ];

    public function channelStreams()
    {
        return $this->belongsTo(\App\Models\IptvStream::class, 'channel_id', 'channel');
    }
}
