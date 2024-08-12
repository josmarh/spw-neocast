<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FileUploads;
use App\Models\Channels;
use App\Models\ChannelPlaylist;
use App\Models\ChannelReport;
use App\Models\Websites;
use App\Models\WebChannels;
use App\Models\LiveStream;
use App\Models\LivestreamVideos;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\UsersResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use Illuminate\Validation\Rules\Password;
use DB;


class UserManagerController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('email');

        if(isset($email)) {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role', 'users.created_at as joined_date','users.is_active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->where('users.email','like', '%'.$email.'%')
                ->orderBy('users.created_at', 'desc')
                ->with('user')
                ->paginate(12);
        }else {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role', 'users.created_at as joined_date','users.is_active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->orderBy('users.created_at', 'desc')
                ->with('user')
                ->paginate(12);

            // $users = User::orderBy('created_at', 'desc')
            //     ->with('user')
            //     ->paginate(12);
        }

        return UsersResource::collection($users);
    }

    public function resellerIndex(Request $request)
    {
        $user = $request->user();
        $email = $request->query('email');

        if(isset($email)) {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role', 'users.created_at as joined_date','users.is_active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->where('users.created_by', $user->id)
                ->where('users.email','like', '%'.$email.'%')
                ->orderBy('users.created_at', 'desc')
                ->with('user')
                ->paginate(12);
        }else {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role', 'users.created_at as joined_date','users.is_active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->where('users.created_by', $user->id)
                ->orderBy('users.created_at', 'desc')
                ->with('user')
                ->paginate(12);

            // $users = User::where('created_by', $user->id)
            //     ->orderBy('created_at', 'desc')
            //     ->with('user')
            //     ->paginate(12);
        }

        return UsersResource::collection($users);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        if($data['password'] == '') {
            $request->validate([
                'email' => 'required|email|string|exists:users,email',
            ]);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email']
            ]);
        } else {
            $request->validate([
                'email' => 'required|email|string|exists:users,email',
                'password' => [
                    'required', 'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }

        if($data['old_role'] != $data['new_role'] && $data['old_role'] != null) {
            $user->removeRole($data['old_role']);
            $user->assignRole($data['new_role']);
        }else{
            $user->assignRole($data['new_role']);
        }

        return response([
            'message' => 'User updated.',
            'status_code' => 200,
        ]);
    }

    public function blockUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->type == 1) {
            $message = 'User Unblocked';
        } else {
            $message = 'User Blocked';
        }

        $user->update([
            'is_active' => $request->type
        ]);

        return response([
            'message' => $message,
            'status_code' => 200,
        ]);
    }

    public function permissions(Request $request)
    {
        $name = $request->query('name');

        // if(isset($name)) {
        //     $permissions = Permission::where('name', 'like', '%'.$name.'%')
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(12);
        // }else {
        //     $permissions = Permission::orderBy('created_at', 'desc')->paginate(12);
        // }
        $permissions = Permission::whereIn('name', [
            'front_end',
            'traffic_booster', 
            'agency_setup',
            'channel_setup',
            'bundle',
            'reseller',
            'fass_pass',
            'affiliate_marketing',
            'unlimited_edition',
            'bonus_menu'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return PermissionResource::collection($permissions);
    }

    public function permissionStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $permission = Permission::create(['name' => $data['name']]);

        return response([
            'data' => $permission,
            'message' => 'Permission Added',
            'status_code' => 201,
        ]);
    }

    public function permissionUpdate(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $permission->update(['name' => $data['name']]);

        return response([
            'data' => new PermissionResource($permission),
            'message' => 'Permission updated',
            'status_code' => 201,
        ]);
    }

    public function permissionDelete($id)
    {
        $role = Permission::findOrFail($id);

        // check all users with that role in role has permissions table and detach

        return response([

        ]);
    }

    public function permissionAssignRole(Request $request)
    {
        $permissions = $request->permissions;
        $unpermit = $request->unpermit;
        $roleId = $request->roleId;

        $role = Role::findOrFail($roleId);

        if(!empty($unpermit)){
            foreach($unpermit as $unpermitt){
                $role->revokePermissionTo($unpermitt);
            }
        }
       
        foreach($permissions as $permission){
            $role->givePermissionTo($permission);
        }

        return response([
            'message' => 'Permission Assigned',
            'status_code' => 200,
        ]);
    }

    public function roles(Request $request)
    {
        $name = $request->query('name');

        // if(isset($name)) {
        //     $roles = Role::where('name', 'like', '%'.$name.'%')
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(12);
        // }else {
        $roles = Role::whereIn('name',[
            'FE',
            'Fast-Pass Deal',
            'DFY Traffic Booster',
            'DFY Online TV Channel Agency Setup',
            '10 DFY TV Channel Setup',
            'Reseller',
            'Affiliate Marketing Coaching Program',
            'Unlimited Edition',
            'Bundle'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        // }

        return RoleResource::collection($roles);
    }

    public function roleStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $role = Role::create(['name' => $data['name']]);

        return response([
            'data' => $role,
            'message' => 'Role Added',
            'status_code' => 201,
        ]);
    }

    public function roleUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $role->update(['name' => $data['name']]);

        return response([
            'data' => new RoleResource($role),
            'message' => 'Role updated',
            'status_code' => 201,
        ]);
    }

    public function rolePermissions(Request $request, $roleId)
    {
        $permissions =  $this->rawQuery("SELECT p.id, p.name, rp.role_id FROM permissions p
            left join role_has_permissions rp on p.id=rp.permission_id and rp.role_id = '$roleId'
            where p.name in ('front_end',
            'traffic_booster', 
            'agency_setup',
            'channel_setup',
            'bundle',
            'reseller',
            'fass_pass',
            'affiliate_marketing',
            'unlimited_edition',
            'bonus_menu')
            order by 1");

        return response([
            'data' => $permissions,
            'status_code' => 200
        ]);
    }

    public function roleAssignUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $request->old_role;
        $newRole = $request->new_role;

        $user->removeRole($oldRole);
        $user->assignRole($newRole);

        return response([
            'message' => 'Role Assigned',
            'status_code' => 200,
        ]);
    }

    public function roleDelete($id)
    {
        $role = Role::findOrFail($id);

        // check all users with that role in role has permissions table and detach

        return response([

        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

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

        // user
        // $user->removeRole(['User', 'Admin', 'Super Admin']);
        $user->delete();

        return response([
            'message' => 'User deleted.',
            'status_code' => 204,
        ]);
    }
}
