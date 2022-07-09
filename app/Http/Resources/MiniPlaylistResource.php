<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class MiniPlaylistResource extends JsonResource
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
            'id' => $this->vhash,
            'name' => $this->file_name,
            'duration' => $this->duration_seconds,
            'thumbnail' => URL::to($this->thumbnail),
            'url' => URL::to($this->file_hash)
        ];
    }
}
