<?php

namespace App\Http\Controllers;

use App\Models\Timezone;
use App\Models\VideoSchedule;
use App\Http\Resources\VideoScheduleResource;
use Illuminate\Http\Request;

class VideoScheduleController extends Controller
{
    public function timezones()
    {
        return Timezone::select('country_code','country_name','time_zone','gmt_offset')->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $schedules = VideoSchedule::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return VideoScheduleResource::collection($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'batchId' => ['required','string'],
            'timezone' => ['required','string'],
            'scheduleTime' => ['required'],
            'scheduleChannel' => ['required','integer'],
            'scheduleVideoSource' => ['required','string'],
        ]);

        VideoSchedule::create([
            'batch_id' => $data['batchId'],
            'timezone' => $data['timezone'],
            'scheduled_at' => $data['scheduleTime'],
            'channel' => $data['scheduleChannel'],
            'video_source' => $data['scheduleVideoSource'],
            'scheduled_videos' => $request->scheduleVideos,
            'ai_keyword' => $request->scheduleKeyword,
            'ai_content' => $request->scheduleContent,
            'ai_actor_id' => $request->scheduleActorId,
            'status' => 'scheduled',
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Schedule created.'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
