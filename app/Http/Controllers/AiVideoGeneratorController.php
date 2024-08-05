<?php

namespace App\Http\Controllers;

use App\Models\VideoScript;
use App\Models\FileUploads;
use App\Models\PipioVideoLanguage;
use App\Services\PipioVideoService;
use App\Services\ChatgptService;
use App\Services\FileHandler;
use App\Helpers;
use App\Jobs\SaveAiVideoToLocalJob;
use Illuminate\Http\Request;
use Log;

class AiVideoGeneratorController extends Controller
{
    public function pipioVideoLanguage()
    {
        return PipioVideoLanguage::all();
    }

    public function lastVideoScript(Request $request)
    {
        $user = $request->user();
        $videoScript = VideoScript::select('topic','content')
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'data' => $videoScript ?? (object)[]
        ]);
    }

    public function generateAiScript(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'topic' => ['required','string']
        ]);
        $data['topic'] = "Create a script that shouldn't be more than 3500 characters in length on the topic: ".$data['topic'].". Provide key points, interesting facts, and insights to captivate the audience. Avoid specific cues like opening music, host prompts, and background music instructions. Make it like an article";

        try {
            $chatgptService = new ChatgptService();
            $response = $chatgptService->generateVideoScript($data['topic']);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
                'status' => 422
            ],422);
        }

        $words = 0;
        if($response['choices']) {
            $content = '';
            foreach ($response['choices'] as $key => $value) {
                $content .= trim($value["text"]) . "\r\n\r\n";
                $words += count(explode(" ", trim($content)));
            }
        }else {
            $content = trim($response['choices'][0]["text"]);
            $words = count(explode(" ", $content));
        }

        VideoScript::updateOrCreate(
            ['user_id' => $user->id],
            [
                'topic' => $request->topic,
                'content' => $content,
            ]
        );
//         $content = "Understanding Affiliate Marketing:

// Affiliate marketing is a performance-based marketing strategy where a business rewards affiliates for driving traffic or sales to their website through the affiliate's marketing efforts. It is a popular and cost-effective way for businesses to reach a larger audience and increase sales.

// Affiliate marketing works on the principle of revenue sharing, where affiliates are compensated for each visitor or customer they bring to the business through their marketing efforts. Affiliates can promote products or services through various channels such as websites, social media, email marketing, and more.

// The key players in affiliate marketing are the merchant, the affiliate, and the consumer. The merchant is the business that offers products or services to be promoted, the affiliate is the marketer who promotes these products or services, and the consumer is the person who makes a purchase or takes a desired action.

// Affiliate marketing is a win-win situation for all parties involved. The merchant benefits from increased sales and brand exposure, the affiliate earns a commission for each sale or lead generated, and the consumer gets access to products or services that meet their needs.

// To succeed in affiliate marketing, it is important to choose the right affiliate programs, select products or services that align with your target audience, create high-quality content that drives traffic and conversions, and continuously optimize your marketing strategies for better results.

// Understanding the basics of affiliate marketing is essential for anyone looking to leverage AI for affiliate marketing success. By understanding the principles and strategies behind affiliate marketing, you can effectively implement AI tools and techniques to optimize your campaigns, increase conversions, and maximize your earnings.";
//         $words = count(explode(" ", $content));

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
            'actorId' => ['required','string'],
            'language' => ['required','string'],
            'script' => ['required','string']
        ]);

        $pipioVideoService = new PipioVideoService();
        try {
            $response = $pipioVideoService->generateVideo($data);
            // Log::debug(json_encode($response));
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
            'ai_video_status' => 'ongoing'
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
            Log::info('Video ID:'.$videoId);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ],422);
        }

        if($videoData['status'] == 'Completed'){
            dispatch(new SaveAiVideoToLocalJob([
                'videoUrl' => $videoData['videoUrl'],
                'videoId' => $videoId
            ]));

            return response()->json([
                'message' => 'Video rendering completed. Saving video...',
                'videoStatus' => 'completed',
                'videoUrl' => $videoData['videoUrl']
            ]);
        }else if($videoData['status'] == 'Pending'){
            return response()->json([
                'message' => 'Hold on video is still rendering...',
                'videoStatus' => 'rendering'
            ]);
        }else if($videoData['status'] == 'Failure' || $videoData['status'] == 'Cancelled'){
            return response()->json([
                'message' => 'An error occurred when rendering video, please try again',
                'videoStatus' => $videoData['status']
            ],422);
        }
        return response()->json([
            'item' => $videoData,
            'videoStatus' => $videoData['status']
        ]);
    }

    public function checkAiVideoSaveStatus($videoId)
    {
        $fileUpload = FileUploads::where('ai_video', $videoId)->first();
        if($fileUpload){
            return response()->json([
                'videoStatus' => $fileUpload->ai_video_status,
                'videoUrl' => env('APP_URL').'/'.$fileUpload->file_hash,
                'message' => 'Saving video...'
            ]);
        }
        return response()->json([
            'message' => 'video not found.'
        ],404);
    }
}
