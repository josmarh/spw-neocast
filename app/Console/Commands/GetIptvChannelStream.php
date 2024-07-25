<?php

namespace App\Console\Commands;

use App\Models\IptvStream;
use App\Services\IptvService;
use Illuminate\Console\Command;

class GetIptvChannelStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-iptv-channel-stream';

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
        $this->info('Fetch IPTV channel stream started...');
        $iptvService = new IptvService();
        $iptvStreams = $iptvService->getStreams();

        $this->info('Inserting channel stream data into stream table...');
        foreach($iptvStreams as $stream){
            IptvStream::updateOrCreate(
                ['channel' => $stream['channel']],
                [
                    'url'           => $stream['url'],
                    'timeshift'     => $stream['timeshift'],
                    'http_referrer' => $stream['http_referrer'],
                    'user_agent'    => $stream['user_agent']
                ]
            );
        }
        $this->info('Fetch IPTV channel stream completed...'.count($iptvStreams));
    }
}
