<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Channels;
use App\Models\ChannelPlaylist;
use App\Models\FileUploads;
use App\Http\Resources\ChannelResource;
use App\Http\Resources\PlaylistResource;
use App\Http\Resources\MiniPlaylistResource;
use App\Http\Controllers\UploadsController;
use Carbon\Carbon;
use DB;
use URL;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $filter = request()->query('name');

        if(isset($filter)) {
            $channels = Channels::select(DB::raw('channels.*, count(cpl.id) as total_vidoes, sum(cpl.views) as total_views, cpl.video_thumbnail'))
                ->leftJoin('channel_playlists as cpl', 'cpl.channel_hash', '=', 'channels.channel_hash')
                ->where('channels.user_id', $user->id)
                ->where('channels.title', 'like', '%'.$filter.'%')
                ->groupBy('channels.id')
                ->orderBy('channels.created_at', 'desc')
                ->paginate(10);
        }else {
            $channels = Channels::select(DB::raw('channels.*, count(cpl.id) as total_vidoes, sum(cpl.views) as total_views, cpl.video_thumbnail'))
                ->leftJoin('channel_playlists as cpl', 'cpl.channel_hash', '=', 'channels.channel_hash')
                ->where('channels.user_id', $user->id)
                ->groupBy('channels.id')
                ->orderBy('channels.created_at', 'desc')
                ->with('channel_playlist')
                ->paginate(10);
        }

        return ChannelResource::collection($channels);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $relativePath = null;

        $request->validate([
            'title' => 'required|string|unique:channels,title',
            'description' => 'required|string|max:200'
        ]);

        if (isset($request->logo)) {
            $relativePath = $this->extractUrl($request->logo);
        }

        Channels::create([
            'title' => $request->title,
            'description' => $request->description,
            'schedule_duration' => $request->schedule,
            'schedule_daytime' => json_encode($request->scheduleDaytime),
            'start_time' => $request->starttime,
            'timezone' => $request->timezone,
            'logo' => $relativePath,
            'logo_enable' => $request->logoEnable,
            'logo_link' => $request->logolink,
            'logo_position' => $request->logoposition,
            'color' => $request->color,
            'twitter' => $request->twitter,
            'privacy' => $request->privacy,
            'privacy_domain' => $request->privacydomain,
            'ad_tag_url' => $request->adtagurl,
            'channel_type' => $request->channeltype,
            'channel_hash' => strtolower(Str::random(32)),
            'stream_name' => strtolower(Str::random(32)),
            'user_id' => $user->id,
        ]);

        return response([
            'message' => 'Channel created successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }

    public function edit($hash)
    {
        $currentDateTime = Carbon::now();
        $channel = Channels::where('channel_hash', $hash)->first();

        return new ChannelResource($channel);
    }

    public function external($hash)
    {
        $now = Carbon::now('UTC');
        $time  = $now->format('H:i');
        $day  = $now->format('l');
        $channel = Channels::where('channel_hash', $hash)->first();

        if($channel->channel_type == 'Looped (Linear)') {
            if ($time >= $channel->start_time) {
                $channelInfo = new ChannelResource($channel);
                $message = 'success';
            }else {
                $channelInfo = [];
                $message = 'This channel is not available at the moment, please check back later.';
            }

        } elseif ($channel->channel_type == 'Scheduled (Linear)') {
            if($channel->schedule_duration == 'weekly') {
                $schedules = json_decode($channel->schedule_daytime);
                $message = '';

                foreach($schedules as $schedule){
                    if($day == $schedule->day && $time >= $schedule->starttime) {
                        $channelInfo = new ChannelResource($channel);
                        $message = 'success';
                        break;
                    }
                }
                if($message == '') {
                    $channelInfo = [];
                    $message = 'This channel is not available at the moment, please check beck later.';
                }
            } else {
                if ($time >= $channel->start_time) {
                    $channelInfo = new ChannelResource($channel);
                    $message = 'success';
                }else {
                    $channelInfo = [];
                    $message = 'This channel is not available at the moment, please check beck later.';
                }
            }
        } else {
            $channelInfo = new ChannelResource($channel);
            $message = 'success';
        }

        return response(['data' => $channelInfo, 'message' => $message]);
    }

    public function update(Request $request, $id)
    {
        $channel = Channels::findOrFail($id);
        $relativePath = $request->logo;

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string|max:200'
        ]);

        if (isset($request->logo)) {
            // check content type
            $host = $request->getSchemeAndHttpHost();
            if(strpos($request->logo, $host) !== false) {
                $relativePath = str_ireplace($host.'/', '', $request->logo);
            }else {
                $relativePath = $this->extractUrl($request->logo);
            }
        }

        $channel->update([
            'title' => $request->title,
            'description' => $request->description,
            'schedule_duration' => $request->schedule,
            'schedule_daytime' => json_encode($request->scheduleDaytime),
            'start_time' => $request->starttime,
            'timezone' => $request->timezone,
            'logo_enable' => $request->logoEnable,
            'logo' => $relativePath,
            'logo_link' => $request->logolink,
            'logo_position' => $request->logoposition,
            'color' => $request->color,
            'twitter' => $request->twitter,
            'privacy' => $request->privacy,
            'privacy_domain' => $request->privacydomain,
            'ad_tag_url' => $request->adtagurl,
            'channel_type' => $request->channeltype,
        ]);

        return response([
            'contents' => new ChannelResource($channel),
            'status' => 'Channel updated successfully',
            'status_code' => 200,
        ]);
    }

    public function duplicateChannel(Request $request)
    {
        $user = $request->user();
        $channel = Channels::where('channel_hash', $request->chash)->first();
        $channelVideo = ChannelPlaylist::where('channel_hash', $request->chash)->get();

        $newChannel = Channels::create([
            'title' => $request->title,
            'description' => $channel->description,
            'schedule_duration' => $channel->schedule_duration,
            'schedule_daytime' => $channel->schedule_daytime,
            'start_time' => $channel->start_time,
            'timezone' => $channel->timezone,
            'logo_enable' => $channel->logo_enable,
            'logo' => $channel->logo,
            'logo_link' => $channel->logo_link,
            'logo_position' => $channel->logo_position,
            'color' => $channel->color,
            'twitter' => $channel->twitter,
            'privacy' => $channel->privacy,
            'privacy_domain' => $channel->privacy_domain,
            'ad_tag_url' => $channel->ad_tag_url,
            'channel_type' => $channel->channel_type,
            'channel_hash' => strtolower(Str::random(32)),
            'stream_name' => strtolower(Str::random(32)),
            'user_id' => $user->id,
        ]);

        foreach($channelVideo as $vId){
            ChannelPlaylist::create([
                'channel_hash' => $newChannel->channel_hash,
                'video_id' => $vId->video_id
            ]);
        }

        return response([
            'message' => 'Channel created successfully',
            'status' => 'success',
            'status_code' => 201
        ]);
    }

    public function delete($id)
    {
        $channel = Channels::findOrFail($id);

        File::delete(public_path().'/'.$channel->logo);

        $channel->delete();

        return response([
            'message' => 'Channel deleted successfully.',
            'status' => 'success',
            'status_code' => 204
        ]);
    }

    // Redundant
    public function streamVideo($chash)
    {
        $playlist = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash', 'ch.title', 'cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->join('channels as ch', 'ch.channel_hash', '=', 'cp.channel_hash')
            ->whereIn('file_uploads.id', function($query)use($chash){
                $query->select('video_id')->from('channel_playlists');
            })
            ->where('cp.channel_hash', $chash)
            ->orderBy('file_uploads.created_at', 'desc')
            ->get();

        foreach($playlist as $stream) {
            shell_exec('ffmpeg -re -i "'.$stream->file_hash.'"-c:v copy -c:a aac -ar 44100 -ac 1 -f flv rtmp://tubetargeterapp.com:2446/app');
        }

        return 'completed';
    }

    public function roku(Request $request, $chash)
    {
        $format = $request->query('format');

        $channel = Channels::where('channel_hash', $chash)->first();
        $playlist = FileUploads::select('file_uploads.*','cp.views','cp.channel_hash', 'ch.title', 'cp.id as cpId')
            ->join('channel_playlists as cp', 'cp.video_id', '=', 'file_uploads.id')
            ->join('channels as ch', 'ch.channel_hash', '=', 'cp.channel_hash')
            ->whereIn('file_uploads.id', function($query)use($chash){
                $query->select('video_id')->from('channel_playlists');
            })
            ->where('cp.channel_hash', $chash)
            ->orderBy('file_uploads.created_at', 'desc')
            ->get();

        if(isset($format)) {
            if($format == 'roku_json' && str_contains($channel->channel_type, 'Linear')) {
                $channelTitle = explode('(Linear)', $channel->channel_type)[0] . 'Channel';
                
                return response([
                    'providerName' => env('APP_NAME'),
                    'lastUpdated' => $channel->updated_at,
                    'language' => 'en',
                    'description' => $channel->description,
                    'liveFeeds' => [
                        [
                            'id' => $channel->channel_hash,
                            'title' => $channelTitle,
                            'content' => [
                                'dateAdded' => $channel->created_at,
                                'videos' => [
                                    [
                                        'url' => env('STREAM_URI').'/channels/'.$channel->stream_name.'.m3u8',
                                        'quality' => 'FHD',
                                        'videoType' => 'HLS'
                                    ]
                                ],
                                'language' => 'en',
                            ],
                            'language' => 'en',
                            'thumbnail' => URL::to('customs/default.jpg'),
                            'brandedThumbnail' => URL::to('customs/default.jpg'),
                            'shortDescription' => $channelTitle,
                            'longDescription' => $channelTitle,
                            'rating' => [
                                'rating' => 'PG',
                                'ratingSource' => 'USA_PR',
                            ],
                            'tags' => [
                                'live'
                            ]
                        ]
                    ],
                ]);
            } elseif ($format == 'amazon_fire' && str_contains($channel->channel_type, 'Linear')) {
                $email = $channel->users->email;
                $channelLogo = $channel->logo == null ? $channel->logo_link : URL::to($channel->logo);
                $shareLink = env('FE_APP_URI').'/watch/channel/'.$chash;
                $playlistData = '';

                foreach($playlist as $item) {
                    $playlistData .=
        '<item>
            <title>'.$item->file_name.'</title>
            <pubDate>'.$item->created_at.'</pubDate>
            <link>'.URL::to($item->file_hash).'</link>
            <guid isPermaLink="false">'.URL::to($item->file_hash).'</guid>
            <media:category>All</media:category>
            <media:content url="'.URL::to($item->file_hash).'" language="en-US" fileSize="'.$item->file_size.'" duration="'.$item->duration_seconds.'" medium="video" isDefault="true">
                <media:title type="plain">'.$item->file_name.'</media:title>
                <media:thumbnail url="'.URL::to($item->thumbnail).'"></media:thumbnail>
                <media:credit role="author" scheme="urn:ebu">'.$channel->users->name.'</media:credit>
            </media:content>
        </item>';
                }

                $xmlstr = 
'<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">
    <channel>
        <title>'.$channel->title.'</title>
        <link>'.$shareLink.'</link>
        <language>en-us</language>
        <pubDate>'.$channel->created_at.'</pubDate>
        <lastBuildDate>'.$channel->updated_at.'</lastBuildDate>
        <managingEditor>'.$email.'</managingEditor>
        <description>'.$channel->description.'</description>
        <image>
            <link>'.$shareLink.'</link>
            <title>'.$channel->title.'</title>
            <url>'.$channelLogo.'</url>
            <height>114</height>
            <width>114</width>
        </image>
        <atom:link href="'.$shareLink.'" rel="self" type="application/rss+xml"></atom:link>
        '. $playlistData .'
    </channel>
';

                // $note = new \SimpleXMLElement($xmlstr);

                return response($xmlstr, 200)->header('Content-Type', 'text/plain');
            } else {
                return response([
                    'message' => 'The selected format is invalid.',
                    'error' => 0,
                ]);
            }
        } else {
            return response([
                'id' => $chash,
                'name' => $channel->title,
                'type' => str_contains($channel->channel_type, 'Linear') ? 'LOP' : 'SCH',
                'period' => str_contains($channel->channel_type, 'Linear') ? $channel->schedule_duration : null,
                'color' => $channel->color,
                'domain_restriction' => $channel->privacy == 'anywhere' ? 0 : json_decode($channel->privacy_domain),
                'thumbnail' => count($playlist) > 0 ? URL::to($playlist[0]->thumbnail) : null,
                'content' => MiniPlaylistResource::collection($playlist)
            ]);
        }
    }

    private function extractUrl($file)
    {
        // check if it's a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
            // take out the base64 encoded text without mimetype
            $file = substr($file, strpos($file, ',') +1);
            // get file extension 
            $type = strtolower($type[1]);
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);

            if($file === false) {
                throw new Exception("base64_decode failed");
            }
        } else {
            throw new Exception("Did not match data URI with file data");
        }

        $dir = 'channel_logos/';
        $fileHash = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileHash;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $file);

        return $relativePath;
    }
}
