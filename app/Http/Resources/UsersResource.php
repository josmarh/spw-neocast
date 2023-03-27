<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'name' => $this->username ? $this->username : $this->name,
            'email' => $this->uemail ? $this->uemail : $this->email,
            'role' => $this->role,
            'active' => $this->is_active,
            'youtube' => $this->youtube_api_key,
            'created_by' => new UsersResource($this->whenLoaded('user')),
            'created_at' => $this->joined_date,
        ];
    }
}
