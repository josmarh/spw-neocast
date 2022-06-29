<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ChannelPlaylist;

class Channels extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'schedule_duration',
        'start_time',
        'timezone',
        'logo_enable',
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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function channel_playlist()
    {
        return $this->hasMany(ChannelPlaylist::class, 'channel_hash','channel_hash');
    }

}
