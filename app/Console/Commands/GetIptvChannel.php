<?php

namespace App\Console\Commands;

use App\Models\IptvChannel;
use App\Services\IptvService;
use Illuminate\Console\Command;

class GetIptvChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-iptv-channels';

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
        $this->info('Fetch IPTV channels started...');
        $iptvService = new IptvService();
        $iptvChannels = $iptvService->getChannels();

        $this->info('Inserting data into channel table...');
        foreach($iptvChannels as $channel){
            IptvChannel::updateOrCreate(
                ['channel_id' => $channel['id']],
                [
                    'name'      => $channel['name'],
                    'alt_names' => json_encode($channel['alt_names']),
                    'network'   => $channel['network'],
                    'owners'    => json_encode($channel['owners']),
                    'country'   => $channel['country'],
                    'subdivision'   => $channel['subdivision'],
                    'city'          => $channel['city'],
                    'broadcast_area'=> json_encode($channel['broadcast_area']),
                    'languages'     => json_encode($channel['languages']),
                    'categories'    => json_encode($channel['categories']),
                    'is_nsfw'       => $channel['is_nsfw'],
                    'launched'      => $channel['launched'],
                    'closed'        => $channel['closed'],
                    'replaced_by'   => $channel['replaced_by'],
                    'website'       => $channel['website'],
                    'logo'          => $channel['logo']
                ]
            );
        }
        $this->info('Fetch IPTV channels completed...'.count($iptvChannels));
    }
}
