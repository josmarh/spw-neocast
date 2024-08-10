<?php

namespace App\Services;

class YoutubeDownload
{
    private string $apiKey;
    public string $videoId;

    public function __construct($videoId)
    {
        $this->apiKey = config('services.youtube.key');
        $this->videoId = $videoId;
    }
    
    public function handle()
    {
        $videoUrl = "https://www.youtube.com/watch?v=".$this->videoId;
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match);
        $youtubeVideoId = $match[1];

        $videoMeta = json_decode($this->getYoutubeVideoMeta($this->videoId, $this->apiKey));
        $videoTitle = $videoMeta->videoDetails->title;
        $videoFormats = $videoMeta->streamingData->formats;
        $adaptiveFormats = $videoMeta->streamingData->adaptiveFormats;
        $selectDownload = [];

        foreach ($adaptiveFormats as $videoFormat){
            if(\property_exists($videoFormat, 'mimeType') && \property_exists($videoFormat, 'qualityLabel')){
                $mimeType = explode(";",explode("/",$videoFormat->mimeType)[1])[0];
                $videoQuality = $videoFormat->qualityLabel;

                if($mimeType == 'mp4' && $videoQuality == '720p'){
                    try {
                        $url = $videoFormat->url;
                    } catch (Exception $e) {
                        $signature = $videoFormat->signatureCipher;
                        parse_str(parse_url($signature, PHP_URL_QUERY), $parse_signature);
                        $url = $parse_signature['url'];
                    }

                    $selectDownload = [
                        'title' => $videoTitle,
                        'type' => $mimeType,
                        'url' => $url,
                        'filename' => $videoTitle.'.'.$mimeType
                    ];
                }
            }
        }

        if(count($selectDownload)>0)
            return $this->downloadVideo($selectDownload);
        else throw new Exception("Error downloading youtube video", 1);
    }
    
    private function getYoutubeVideoMeta($videoId, $key)
    {
        $ch = curl_init();
        $curlUrl = 'https://www.youtube.com/youtubei/v1/player?key=' . $key;
        curl_setopt($ch, CURLOPT_URL, $curlUrl);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $curlOptions = '{"context": {"client": {"hl": "en","clientName": "WEB",
        "clientVersion": "2.20210721.00.00","clientFormFactor": "UNKNOWN_FORM_FACTOR","clientScreen": "WATCH",
        "mainAppWebInfo": {"graftUrl": "/watch?v=' . $videoId . '",}},"user": {"lockedSafetyMode": false},
        "request": {"useSsl": true,"internalExperimentFlags": [],"consistencyTokenJars": []}},
        "videoId": "' . $videoId . '",  "playbackContext": {"contentPlaybackContext":
        {"vis": 0,"splay": false,"autoCaptionsDefaultOn": false,
        "autonavState": "STATE_NONE","html5Preference": "HTML5_PREF_WANTS","lactMilliseconds": "-1"}},
        "racyCheckOk": false,  "contentCheckOk": false}';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlOptions);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $curlResult = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $curlResult;
    }

    private function downloadVideo($data)
    {
        $downloadURL = $data['url'];
        $downloadFileName = $data['title'] . '.' . $data['type'];
        if (! empty($downloadURL) && substr($downloadURL, 0, 8) === 'https://') {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment;filename=\"$downloadFileName\"");
            header("Content-Transfer-Encoding: binary");
            return readfile($downloadURL);
        }
    }
}