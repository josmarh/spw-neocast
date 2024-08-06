<?php

namespace App\Http\Resources;

use App\Models\VideoSchedule;
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
        if($this->video_source == 'ai-content'){
            $scheduledVideos = VideoSchedule::where('batch_id', $this->batch_id)->count();
        }else {
            $scheduledVideos = count(json_decode($this->scheduled_videos));
        }
        return [
            'id' => $this->id,
            'batchId' => $this->batch_id,
            'timezone' => $this->timezone,
            'scheduledTime' => Carbon::create($this->scheduled_at)->toDayDateTimeString(),
            'channel' => new ChannelResource($this->channelRef),
            'videos' => $scheduledVideos,
            'status' => $this->status
        ];
    }
}
