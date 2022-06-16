<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Websites extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'channel',
        'url_path',
        'logo',
        'favicon',
        'header',
        'page_layout',
        'bg_color',
        'font_color',
        'autoplay',
        'volume',
        'controls',
        'content_title',
        'share_button',
        'footer_text',
        'seo_site_meta',
        'whash',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
