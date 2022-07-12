<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PlaylistResource;
use URL;


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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'schedule_duration' => $this->schedule_duration,
            'schedule_daytime' => $this->schedule_daytime,
            'start_time' => $this->start_time,
            'timezone' => $this->timezone,
            'logo_enable' => $this->logo_enable,
            'logo' => $this->logo ? URL::to($this->logo) : null,
            'logo_link' => $this->logo_link,
            'logo_position' => $this->logo_position,
            'color' => $this->color,
            'twitter' => $this->twitter,
            'privacy' => $this->privacy,
            'privacy_domain' => $this->privacy_domain,
            'ad_tag_url' => $this->ad_tag_url,
            'channel_type' => $this->channel_type,
            'channel_hash' => $this->channel_hash,
            'stream_name' => $this->stream_name,
            'roku_link' => URL::to('channel/w/'. $this->channel_hash . '?format=roku_json'),
            'total_vidoes' => $this->total_vidoes,
            'total_views' => $this->total_views,
            'thumbnail' => $this->video_thumbnail ? URL::to($this->video_thumbnail) : null,
            // 'channelplaylist' => PlaylistResource::collection($this->whenLoaded('channel_playlist')),
        ];
    }
}
