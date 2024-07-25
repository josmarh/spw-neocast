<?php

namespace App\Http\Resources;

use App\Http\Resources\IptvSreamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IptvChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'channel'   => $this->channel_id,
            'name'      => $this->name,
            'categories'=> json_decode($this->categories),
            'website'   => $this->website,
            'logo'      => $this->logo,
            'stream'    => new IptvSreamResource($this->channelStreams) 
        ];
    }
}
