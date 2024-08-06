<?php

namespace App\Console\Commands;

use App\Models\IptvCategory;
use Illuminate\Console\Command;
use voku\helper\HtmlDomParser;
use Log;

class ScrapeIptvGithub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-iptv-categories';

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
        $url = 'https://github.com/iptv-org/iptv';
        // $webContent = file_get_contents($url);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $htmlContent = curl_exec($curl);

        if ($htmlContent === false) {
            // handle the error
            $error = curl_error($curl);
            echo "cURL error: " . $error;
            exit;
        }
        curl_close($curl);

        $html = HtmlDomParser::str_get_html($htmlContent);
        $tables = $html->findMulti("table");
        $categoryTable;
        $iptvArr = array();

        foreach ($tables as $key => $table) {
            if($key == 1){
                $categoryTable = $table;
                break;
            }
        }
        if($categoryTable){
            $trows = $categoryTable->find("tbody > tr");
            $tds = array();
            foreach ($trows as $trow) {
                foreach($trow->findMulti("td") as $key => $td){
                    if($key == 0)
                        $tds['category'] = $td->plaintext;
                    elseif($key == 1)
                        $tds['channels'] = (int)$td->plaintext;
                    elseif($key == 2)
                        $tds['playlist'] = $td->plaintext;
                }
                array_push($iptvArr, $tds);
            }
            if(count($iptvArr)>0) { 
                IptvCategory::truncate();
                IptvCategory::insert($iptvArr);
            }
        }
    }
}
