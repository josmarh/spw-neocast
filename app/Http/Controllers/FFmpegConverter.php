<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use URL;

class FFmpegConverter extends Controller
{
    public function mp4ToM3u8()
    {
        $relativePath = public_path().'/m3u8/linear_demo.m3u8';
        $videos = '../uploads/MAeycUoYvY751ZhY.mp4|../uploads/AefaRpOm7BY3EUZQ.mp4';

        try {
            foreach($videos as $video){
                shell_exec('C:\ffmpeg\bin\ffmpeg.exe -i concat -i compiled_videos.txt -b:v 1M -g 60 -hls_time 2 -hls_list_size 0 -hls_segment_size 500000 linear_demo.m3u8' .$relativePath);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $relativePath = URL::to($relativePath);

        return $relativePath;
    }
}

// working demo 
// C:\ffmpeg\bin\ffmpeg.exe -re -f concat -i compiled_videos.txt -b:v 1M -g 60 -hls_time 2 -hls_list_size 0 -hls_segment_size 500000 linear_demo.m3u8