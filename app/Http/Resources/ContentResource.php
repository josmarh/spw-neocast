<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $splitLink = explode('/', $this->file_hash);
        $externalLink = explode('.', $splitLink[1]);

        return [
            'id'            => $this->id,
            'file_name'     => $this->file_name,
            'file_hash'     => $this->file_hash ? URL::to($this->file_hash) : null,
            'file_size'     => $this->file_size,
            'file_type'     => $this->file_type,
            'media_length'  => $this->media_length,
            'tags'          => $this->tags,
            'external_video_link' => $this->external_video_link,
            'upload_types'        => $this->upload_types,
            'external_link'       => $this->file_hash ? $externalLink[0] : null,
            'vhash'               => $this->vhash,
        ];
    }
}
