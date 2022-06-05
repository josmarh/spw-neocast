<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
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
            'title' => $this->title,
            'schedule_duration' => $this->schedule_duration,
            'start_time' => $this->start_time,
            'timezone' => $this->timezone,
            'logo' => $this->logo ? URL::to($this->logo) : null,
            'logo_link' => $this->logo_link,
            'logo_position' => $this->logo_position,
            'color' => $this->color,
            'twitter' => $this->twitter,
            'privacy' => $this->privacy,
            'privacy_domain' => $this->privacy_domain,
            'ad_tag_url' => $this->ad_tag_url,
            'channel_type' => $this->channel_type,
            'channel_hash' => $this->channel_hash
        ];
    }
}
