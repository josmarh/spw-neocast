<?php

namespace App\Http\Resources;

use App\Http\Resources\ChannelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class VideoScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'batchId' => $this->batch_id,
            'timezone' => $this->timezone,
            'scheduledTime' => Carbon::create($this->scheduled_at)->toDayDateTimeString(),
            'channel' => new ChannelResource($this->channelRef),
            'videos' => count(json_decode($this->scheduled_videos)),
            'status' => $this->status
        ];
    }
}
