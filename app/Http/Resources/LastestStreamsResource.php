<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class LastestStreamsResource extends JsonResource
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
            'file_name'     => $this->file_name,
            'file_hash'     => $this->file_hash ? URL::to($this->file_hash) : null,
            'file_size'     => $this->file_size,
            'file_type'     => $this->file_type,
            'media_length'  => $this->media_length,
            'thumbnail'     => $this->thumbnail ? URL::to($this->thumbnail) : null,
        ];
    }
}
