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
use App\Http\Resources\UsersResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagerController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('email');

        if(isset($email)) {
            $users = User::where('email', 'like', '%'.$email.'%')
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(12);
        }else {
            $users = User::orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(12);
        }

        return UsersResource::collection($users);
    }

    public function resellerIndex(Request $request)
    {
        $user = $request->user();
        $email = $request->query('email');

        if(isset($email)) {
            $users = User::where('email', 'like', '%'.$email.'%')
                ->where('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(12);
        }else {
            $users = User::where('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(12);
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

        return response([
            'message' => 'User updated.',
            'status_code' => 200,
        ]);
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => 0
        ]);

        return response([
            'message' => 'User blocked.',
            'status_code' => 200,
        ]);
    }

    public function permissions()
    {
        return Permission::paginate(12);
    }

    public function roles()
    {
        return Role::paginate(12);
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

    public function permissionUpdate($id)
    {
        $permission = Permission::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $permission->update(['name' => $data['name']]);

        return response([
            'data' => $permission,
            'message' => 'Permission updated',
            'status_code' => 201,
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

    public function roleUpdate($id)
    {
        $role = Role::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $role->update(['name' => $data['name']]);

        return response([
            'data' => $role,
            'message' => 'Role updated',
            'status_code' => 201,
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
        $user->delete();

        return response([
            'message' => 'User deleted.',
            'status_code' => 204,
        ]);
    }
}
