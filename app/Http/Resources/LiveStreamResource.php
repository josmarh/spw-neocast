<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveStreamResource extends JsonResource
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
            'channels' => $this->channels,
            'stream_record' => $this->stream_record,
            'broadcast_signal' => $this->broadcast_signal,
            'stream_key' => $this->stream_key,
            'live_status' => $this->live_status,
            'lhash' => $this->lhash
        ];
    }
}
