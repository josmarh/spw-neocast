<?php

namespace App\Http\Controllers;

use App\Models\FileUploads;
use App\Services\PipioVideoService;
use App\Services\ChatgptService;
use App\Services\FileHandler;
use Illuminate\Http\Request;
use Log;

class AiVideoGeneratorController extends Controller
{
    public function generateAiScript(Request $request)
    {
        $data = $request->validate([
            'topic' => ['required','string']
        ]);
        $data['topic'] = "Generate a video script for me with the idea ". $data['topic'];

        // try {
        //     $chatgptService = new ChatgptService();
        //     $response = $chatgptService->generateVideoScript($data['topic']);
        // } catch (\Exception $e) {
        //     return response([
        //         'message' => $e->getMessage(),
        //         'status' => 422
        //     ],422);
        // }

        // $words = 0;
        // if($response['choices']) {
        //     $content = '';
        //     foreach ($response['choices'] as $key => $value) {
        //         $content .= trim($value["text"]) . "\r\n\r\n";
        //         $words += count(explode(" ", trim($content)));
        //     }
        // }else {
        //     $content = trim($response['choices'][0]["text"]);
        //     $words = count(explode(" ", $content));
        // }
        $content = "Understanding Affiliate Marketing:

Affiliate marketing is a performance-based marketing strategy where a business rewards affiliates for driving traffic or sales to their website through the affiliate's marketing efforts. It is a popular and cost-effective way for businesses to reach a larger audience and increase sales.

Affiliate marketing works on the principle of revenue sharing, where affiliates are compensated for each visitor or customer they bring to the business through their marketing efforts. Affiliates can promote products or services through various channels such as websites, social media, email marketing, and more.

The key players in affiliate marketing are the merchant, the affiliate, and the consumer. The merchant is the business that offers products or services to be promoted, the affiliate is the marketer who promotes these products or services, and the consumer is the person who makes a purchase or takes a desired action.

Affiliate marketing is a win-win situation for all parties involved. The merchant benefits from increased sales and brand exposure, the affiliate earns a commission for each sale or lead generated, and the consumer gets access to products or services that meet their needs.

To succeed in affiliate marketing, it is important to choose the right affiliate programs, select products or services that align with your target audience, create high-quality content that drives traffic and conversions, and continuously optimize your marketing strategies for better results.

Understanding the basics of affiliate marketing is essential for anyone looking to leverage AI for affiliate marketing success. By understanding the principles and strategies behind affiliate marketing, you can effectively implement AI tools and techniques to optimize your campaigns, increase conversions, and maximize your earnings.";
        $words = count(explode(" ", $content));

        return response()->json([
            'content' => $content,
            'words' => $words
        ]);
    }

    public function getAiActors(Request $request)
    {
        $pageNumber = $request->query('pageNumber');
        $pageSize = $request->query('pageSize');

        $pipioVideoService = new PipioVideoService();
        $actors = $pipioVideoService->getActors($pageNumber, $pageSize);

        $currentTotal = $actors['total'] - ($actors['page'] * 10);
        $actorPage = [
            'nextPage' => $actors['total'] > $currentTotal ? $pageNumber + 1 : null,
            'prevPage' => $actors['page'] > 1 ? $pageNumber - 1 : null,
        ];

        return response()->json([
            'items' => $actors['items'],
            'nextPage' => $actorPage['nextPage'],
            'prevPage' => $actorPage['prevPage'],
            'currentPage' => (int)$pageNumber,
            'total' => $actors['total']
        ]);
    }

    public function generateAiVideo(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'title' => ['required','string'],
            'actorId' => ['required','string'],
            'language' => ['required','string'],
            'script' => ['required','string']
        ]);

        $pipioVideoService = new PipioVideoService();
        try {
            $response = $pipioVideoService->generateVideo($data);
            Log::debug(json_encode($response));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ],422);
        }

        // Save video response id to check video status
        FileUploads::create([
            'upload_types' => 'hosted video',
            'vhash' => bin2hex(random_bytes(16)),
            'user_id'  => $user->id,
            'ai_video' => $response['id'],
        ]);

        return response()->json([
            'message' => 'Video generated successfully. It may take up to 5 minutes to render...',
            'data' => $response
        ]);
    }

    public function checkAiVideoStatus(Request $request, $videoId)
    {
        $pipioVideoService = new PipioVideoService();
        try {
            $videoData = $pipioVideoService->retrieveVideo($videoId);
            Log::debug(json_encode($videoData));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ],422);
        }
        
        if($videoData['status'] == 'Completed'){
            $dir = 'uploads/';
            $videoUrlArr = explode('.', $videoData['videoUrl']);
            $videoUrlCnt = count($videoUrlArr) -1;
            $filename = $videoId.'.'.$videoUrlArr[$videoUrlCnt];

            // Save video on server
            $filePath = FileHandler::saveFromUrl($videoData['videoUrl'], $dir, $filename);
            // Get video thumbnail, size, mimetype, duration, durationInSec
            $helpers = new Helpers();
            $thumbnail = $helpers->generateThumbnail($filePath);
            $duration = $helpers->getDuration($filePath);

            // Save to DB
            FileUploads::where('ai_video', $videoId)
                ->update([
                    'file_name' => $filename,
                    'file_hash' => $filePath,
                    'file_size' => $data['size'],
                    'file_type' => $data['type'],
                    'media_length'     => $duration,
                    'duration_seconds' => $request->durationInSec,
                    'thumbnail' => $thumbnail,
                ]);

            return response()->json([
                'message' => 'Video rendering completed.',
                'videoStatus' => 'completed'
            ]);
        }else if($videoData['status'] == 'Pending'){
            return response()->json([
                'message' => 'The video is currently rendering. Please check back in 5 minutes',
                'videoStatus' => 'rendering'
            ]);
        }else if($videoData['status'] == 'Failure' || $videoData['status'] == 'Cancelled'){
            return response()->json([
                'message' => 'An error occurred when rendering video. Please try again',
                'videoStatus' => $videoData['status']
            ],422);
        }
    }
}
