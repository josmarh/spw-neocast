<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'schedule_duration',
        'start_time',
        'timezone',
        'logo',
        'logo_link',
        'logo_position',
        'color',
        'twitter',
        'privacy',
        'privacy_domain',
        'ad_tag_url',
        'channel_type',
        'channel_hash',
        'user_id'
    ];
}
