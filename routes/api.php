<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChannelPlaylistController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\FFmpegConverter;
use App\Http\Controllers\UserManagerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/personal-info', [AuthController::class, 'updateUser']);
    Route::put('/password/update', [AuthController::class, 'updatePassword']);
    Route::post('/uploads', [UploadsController::class, 'fileUpload']);

    Route::get('videos', [VideoController::class, 'index']);
    Route::group(['prefix' => 'video'], function () {
        Route::put('update', [VideoController::class, 'update']);
        Route::get('download/{id}', [VideoController::class, 'download']);
        Route::delete('delete/{id}', [VideoController::class, 'delete']);
        Route::post('external', [UploadsController::class, 'linkUpload']);
    });

    Route::get('channels', [ChannelController::class, 'index']);
    Route::group(['prefix' => 'channel'], function () {
        Route::post('store', [ChannelController::class, 'store']);
        Route::get('edit/{chash}', [ChannelController::class, 'edit']);
        Route::put('update/{id}', [ChannelController::class, 'update']);
        Route::delete('delete/{id}', [ChannelController::class, 'delete']);
        Route::post('duplicate', [ChannelController::class, 'duplicateChannel']);

        Route::get('videos/{chash}', [ChannelPlaylistController::class, 'videos']);
        Route::get('playlist/{chash}', [ChannelPlaylistController::class, 'playlistVidoes']);
        Route::post('videos', [ChannelPlaylistController::class, 'videoStore']);
        Route::delete('playlist/delete/{cpId}', [ChannelPlaylistController::class, 'deleteVideo']);
    });

    Route::get('websites', [WebsiteController::class, 'index']);
    Route::group(['prefix' => 'website'], function () {
        Route::post('store', [WebsiteController::class, 'store']);
        Route::get('edit/{whash}', [WebsiteController::class, 'edit']);
        Route::put('update/{id}', [WebsiteController::class, 'update']);
        Route::delete('delete/{id}', [WebsiteController::class, 'delete']);
    });

    Route::get('livestreams', [LiveStreamController::class, 'index']);
    Route::group(['prefix' => 'livestream'], function () {
        Route::post('create', [LiveStreamController::class, 'store']);
        Route::get('edit/{lhash}', [LiveStreamController::class, 'edit']);
        Route::put('update/{id}', [LiveStreamController::class, 'update']);
        Route::delete('delete/{id}', [LiveStreamController::class, 'delete']);
        Route::post('store/live', [LiveStreamController::class, 'storeLiveVideo']);
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('card', [ReportController::class, 'cardReport']);
        Route::get('chart', [ReportController::class, 'chartReport']);
    });

    Route::get('users', [UserManagerController::class, 'index']);
    Route::get('reseller', [UserManagerController::class, 'resellerIndex']);
    Route::group(['prefix' => 'user'], function () {
        Route::put('update/{id}', [UserManagerController::class, 'update']);
        Route::put('block/{id}', [UserManagerController::class, 'blockUser']);
        Route::delete('delete/{id}', [UserManagerController::class, 'delete']);
    });

    Route::get('permissions', [UserManagerController::class, 'permissions']);
    Route::post('permission/store', [UserManagerController::class, 'permissionStore']);
    Route::put('permission/update', [UserManagerController::class, 'permissionUpdate']);

    Route::get('roles', [UserManagerController::class, 'roles']);
    Route::post('role/store', [UserManagerController::class, 'roleStore']);
    Route::put('role/update', [UserManagerController::class, 'roleUpdate']);
   
});

Route::post('login', [AuthController::class, 'login']);
Route::get('video/show/{str}', [VideoController::class, 'show']);
Route::get('channel/show/{cId}', [ChannelPlaylistController::class, 'playlistVidoes']);
Route::get('channel/info/{chash}', [ChannelController::class, 'edit']);
Route::put('channel/video/track-views/{chash}', [ChannelPlaylistController::class, 'videoPlayAnalysis']);
Route::get('video/info', [VideoController::class, 'index']);
Route::get('website/content/{urlPath}', [WebsiteController::class, 'webContent']);
Route::get('website/channels/{whash}', [WebsiteController::class, 'websiteChannels']);
Route::get('live/watch/{lhash}', [LiveStreamController::class, 'edit']);
Route::get('converter', [FFmpegConverter::class, 'mp4ToM3u8']);
Route::get('channel/linear/{chash}', [ChannelController::class, 'streamVideo']);
