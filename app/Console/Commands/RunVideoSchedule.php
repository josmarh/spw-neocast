<?php

namespace App\Console\Commands;

use App\Models\ChannelPlaylist;
use App\Models\FileUploads;
use App\Models\Channels;
use App\Models\VideoSchedule;
use App\Jobs\CreateHLSVideos;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RunVideoSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-video-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videoSchedules = VideoSchedule::where('status', 'scheduled')->get();

        if($videoSchedules->count()>0){
            foreach ($videoSchedules as $schedule) {
                $timezone = $schedule->timezone;
                $scheduledAt = $schedule->scheduled_at;
                $channel = $schedule->channel;
                $videos = json_decode($this->scheduled_videos);

                if($timezone && $scheduledAt && $channel && count($videos)>0){
                    $utcTime = $this->getUTC($timezone);
                    $scheduledTime = new \DateTime($scheduledAt);

                    $channelModel = Channels::find($channel);
                    $videoModel = FileUploads::whereIn('id', $videos)->get()->toArray();

                    if($utcTime && $utcTime >= $scheduledTime) {
                        foreach ($videos as $vId) {
                            ChannelPlaylist::create([
                                'channel_hash' => $channelModel->channel_hash,
                                'video_id' => $vId
                            ]);

                        }

                        // check if channel playlist thumbnail is null
                        $channelPlaylist = ChannelPlaylist::where('channel_hash', $channelModel->channel_hash)
                            ->orderBy('created_at','asc')
                            ->first();

                        if(!$channelPlaylist->video_thumbnail){                
                            // update playlist with thumbnail
                            $channelPlaylist->update(['video_thumbnail' => $videoModel[0]->thumbnail]);
                        }

                        if(str_contains($channelModel->channel_type, 'Linear')){
                            $streamInfo = $this->makeStreams($channelModel->channel_hash, $channelModel); 

                            dispatch(new CreateHLSVideos($streamInfo))->delay(5);
                        }

                        VideoSchedule::where('id', $schedule->id)->update([
                            'status' => 'completed'
                        ]);
                    }
                }
            }
        }
    }

    public function getUTC($timezone)
    {
        date_default_timezone_set($timezone);

        return new \DateTime(date('Y-m-d H:i:s'));
    }

    public function makeStreams($channelId, $linearCheck)
    {
        // channel videos
        $videos = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash', 'ch.title', 'cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->join('channels as ch', 'ch.channel_hash', '=', 'cp.channel_hash')
            ->whereIn('file_uploads.id', function($query)use($channelId){
                $query->select('video_id')->from('channel_playlists');
            })
            ->where('cp.channel_hash', $channelId)
            ->orderBy('file_uploads.created_at', 'desc')
            ->get();

        if(count($videos) > 0) {
            // delete file if exist and creat new file        
            $dir = 'uploads/';
            $absolutePath = public_path($dir);
            if(File::exists($absolutePath.$channelId.".txt")){
                File::delete($absolutePath.$channelId.".txt");
            }

            $channelFile = fopen($absolutePath.$channelId.".txt", "a") or die("Unable to open file!");

            foreach($videos as $i => $video) {
                if($i == count($videos) -1) {
                    fwrite($channelFile, "file ".explode('/', $video->file_hash)[1]);
                }else{
                    fwrite($channelFile, "file ".explode('/', $video->file_hash)[1]."\n");
                }
            }

            fclose($channelFile);

            // send for dispatch: videos url, stream_name
            $streamInfo = [
                'filePath' => $absolutePath,
                'fileName' => $channelId.".txt",
                'streamPath' => '/nginx/channels/'.$linearCheck->stream_name,
                // 'streamPath' => public_path('channels/'.$linearCheck->stream_name),
                'type' => 'createHLS'
            ];

            return $streamInfo;
        }else {
            // delete all ${channel} .ts .m3u8 
            $dir = 'uploads/';
            $absolutePath = public_path($dir);
            if(File::exists($absolutePath.$channelId.".txt")){
                File::delete($absolutePath.$channelId.".txt");
            }

            $streamInfo = [
                'filePath' => '/nginx/channels',
                // 'filePath' => public_path('channels/'),
                'fileName' => $linearCheck->stream_name,
                'type' => 'deleteHLS'
            ];

            return $streamInfo;
        }
    }
}
