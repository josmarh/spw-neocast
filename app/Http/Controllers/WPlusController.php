<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;

use App\Notifications\UserCreationNotification;
use App\Notifications\UserUpgradeNotification;
use App\Notifications\UserRefundNotification;

use App\Models\User;
use App\Models\FileUploads;
use App\Models\Channels;
use App\Models\ChannelPlaylist;
use App\Models\ChannelReport;
use App\Models\Websites;
use App\Models\WebChannels;
use App\Models\LiveStream;
use App\Models\LivestreamVideos;
use App\Models\Products;
use App\Models\ProductTransactions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WPlusController extends Controller
{
    public function WPlus(Request $request)
    {
        $data = $request->all();

        if(isset($data['WP_SECURITYKEY']) && $data['WP_SECURITYKEY'] === '90cb79f5b3f07d0c9b835fe405cbaab') {
            if(!$data['WP_ITEM_NUMBER'] || !$data['WP_BUYER_EMAIL'] || !$data['WP_BUYER_NAME'] || !$data['WP_TXNID'] || !$data['WP_ACTION']) {
                return response(['message' => 'Incorrect fields!'], 422);
            }

            $d = [
                'productId'     => $data['WP_ITEM_NUMBER'],
                'customerEmail' => $data['WP_BUYER_EMAIL'],
                'customerName'  => $data['WP_BUYER_NAME'],
                'transactionId' => $data['WP_TXNID'],
                'transactionType' => $data['WP_ACTION']
            ];

            switch ($d['transactionType']) {
                case 'sale':
                    $response = $this->createUser($d);
    
                    return response(['message' => $response]);
    
                    break;
                case 'refund':
                    
                    $response = $this->detachUser($d);
                    
                    return response(['message' => $response]);
    
                    break;
                
            }
        }

        return response(['message' => 'Verification Failed!'], 422);
    }

    private function createUser($data)
    {
        $role = Products::where('product_id', $data['productId'])->first();

        if(!$role){

            return response(['message' => 'Product Validation Failed!'], 422);

            exit(1);
        }

        $email = $data['customerEmail'];
        $password = false;
        $user = User::where('email', $email)->first();
        $userId;

        if(!$user) {
            $password = Str::random(10);
            $userModel;
            $username;

            $newUser = User::create([
                'name'      => $data['customerName'] ? $data['customerName'] : substr($email, 0, strpos($email, '@')),
                'email'     => $email,
                'password'  => bcrypt($password),
                'active_status' => 1,
                'created_by'    => 2,
            ]);

            $newUser->assignRole($role->funnel);
            $userModel = $newUser;
            $username = $newUser->name;
            $userId = $newUser->id;

            $userInfo = [
                'username' => $username, 
                'email'    => $email,
                'password' => $password,
                'product'  => $role->name
            ];

            ProductTransactions::create([
                'user_id'           => $userId ,
                'product_id'        => $data['productId'],
                'transaction_id'    => $data['transactionId'],
                'transaction_type'  => 'sale'
            ]);

            Notification::send($userModel, new UserCreationNotification($userInfo));

            return 'User Created Successfully!';
        }else {
            // if user exist update role
            $currentRole = Role::select('roles.name as name','mr.model_id')
                ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
                ->where('mr.model_id', $user->id)
                ->first();

            if($role->funnel != $currentRole->name){
                $user->removeRole($currentRole->name);
                $user->assignRole($role->funnel);

                $userInfo = [
                    'username'=> $user->name, 
                    'product' => $role->funnel
                ];
                $userId = $user->id;

                ProductTransactions::create([
                    'user_id'           => $userId ,
                    'product_id'        => $data['productId'],
                    'transaction_id'    => $data['transactionId'],
                    'transaction_type'  => 'sale'
                ]);
                
                Notification::send($user, new UserUpgradeNotification($userInfo));

                return 'User Bundle Upgraded!';
            }
        }
    }

    private function detachUser($d)
    {
        // detach user role
        $user = User::where('email', $d['customerEmail'])->first(); 
        $role = Products::where('product_id', $d['productId'])->first();

        if ($user){
            $id = $user->id;
            // channel n channel playlist
            $channels = Channels::where('user_id', $id)->get();
            if($channels){
                foreach($channels as $channel) {
                    $playlists = ChannelPlaylist::where('channel_hash', $channel->channel_hash)->delete();
                    $reports = ChannelReport::where('channel_hash', $channel->channel_hash)->delete();
                }
                Channels::where('user_id', $id)->delete();
            }

            // website n website channel
            $websites = Websites::where('user_id', $id)->get();
            if($websites){
                foreach($websites as $website) {
                    $WebChannels = WebChannels::where('whash', $website->whash)->delete();
                }
                Websites::where('user_id', $id)->delete();
            }

            // live stream n livestream vidoes
            $livestreams = LiveStream::where('user_id', $id)->get();
            if($livestreams){
                foreach($livestreams as $livestream) {
                    $LiveStreamVidoes = LivestreamVideos::where('lhash', $livestream->lhash)->delete();
                }
                LiveStream::where('user_id', $id)->delete();
            }

            // videos
            $videos = FileUploads::where('user_id', $id)->delete();

            $currentRole = Role::select('roles.name as name','mr.model_id')
                ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
                ->where('mr.model_id', $id)
                ->first();

            if($currentRole){
                $user->removeRole($currentRole->name);
                $user->delete();

                $userInfo = [
                    'username'=> $user->name, 
                    'product' => $role->name
                ];

                ProductTransactions::create([
                    'user_id'           => $id,
                    'product_id'        => $d['productId'],
                    'transaction_id'    => $d['transactionId'],
                    'transaction_type'  => 'refund'
                ]);

                Notification::send($user, new UserRefundNotification($userInfo));

                return 'Refund is being processed';
            }
        }
    }
}
