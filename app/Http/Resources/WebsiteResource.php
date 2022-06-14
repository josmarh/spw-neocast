<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class WebsiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'channel'       => $this->channel,
            'url_path'      => $this->url_path,
            'logo'          => $this->logo ? URL::to($this->logo) : null,
            'favicon'       => $this->favicon ? URL::to($this->favicon) : null,
            'header'        => $this->header,
            'page_layout'   => $this->page_layout,
            'bg_color'      => $this->bg_color,
            'font_color'    => $this->font_color,
            'autoplay'      => $this->autoplay,
            'volume'        => $this->volume,
            'controls'      => $this->controls,
            'content_title' => $this->content_title,
            'share_button'  => $this->share_button,
            'footer_text'   => $this->footer_text,
            'seo_site_meta' => $this->seo_site_meta,
            'whash'         => $this->whash,
            'user_id'       => $this->user_id,
        ];
    }
}
