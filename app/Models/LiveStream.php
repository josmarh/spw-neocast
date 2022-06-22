<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'channels',
        'stream_record',
        'broadcast_signal',
        'stream_key',
        'live_status',
        'lhash',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
