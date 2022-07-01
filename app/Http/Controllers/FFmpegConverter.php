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
        // $relativePath = public_path().'/m3u8/linear_demo.m3u8';
        // $videos = '../uploads/MAeycUoYvY751ZhY.mp4|../uploads/AefaRpOm7BY3EUZQ.mp4';

        // try {
        //     foreach($videos as $video){
        //         shell_exec('C:\ffmpeg\bin\ffmpeg.exe concat -i compiled_videos.txt -b:v 1M -g 60 -hls_time 2 -hls_list_size 0 -hls_segment_size 500000 linear_demo.m3u8' .$relativePath);
        //     }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        
        // $relativePath = URL::to($relativePath);

        // return $relativePath;
        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::open(['https://www.tubetargeterapp.com/training-videos/keyword-search-tutor.mp4',
            'https://www.tubetargeterapp.com/training-videos/tag-generator-tutor.mp4'])
            ->exportForHLS()
            ->setSegmentLength(10) // optional
            ->setKeyFrameInterval(48) // optional
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->toDisk('video')
            ->save('adaptive_steve.m3u8');

        return 'done.';
    }
}



// working demo for multiple
// C:\ffmpeg\bin\ffmpeg.exe -re -f concat -i 79cbvpcy94sncenwsgkli3izt1kj2ikm.txt -b:v 1M -g 60 -hls_time 2 -hls_list_size 0 -hls_segment_size 500000 ..\m3u8\linear_demo.m3u8

// test
// C:\ffmpeg\bin\ffmpeg.exe -re -f concat -i compiled_videos.txt -b:v 1M -g 60 -hls_time 10 -hls_list_size 0 -hls_segment_size 500000 ../m3u8/linear_demo.m3u8

// single file
// C:\ffmpeg\bin\ffmpeg.exe -i "https://www.tubetargeterapp.com/training-videos/keyword-search-tutor.mp4" -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls demo.m3u8

// testing multiple on a line 
// C:\ffmpeg\bin\ffmpeg.exe -f -i "https://www.tubetargeterapp.com/training-videos/keyword-search-tutor.mp4" -f -i "https://www.tubetargeterapp.com/training-videos/tag-generator-tutor.mp4" -map 0 -map 1 -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls demo.m3u8
// 

// multiple with htttp
// C:\ffmpeg\bin\ffmpeg.exe -protocol_whitelist file,http,https,tcp,tls -f concat -safe 0 -i compiled_videos.txt -b:v 1M -g 60 -hls_time 10 -hls_list_size 0 -hls_segment_size 500000 linear_demo.m3u8