<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\IPNController;
use App\Http\Controllers\WPlusController;
use App\Http\Controllers\YTubeController;
use App\Http\Controllers\HookerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('channel/{chash}', [ChannelController::class, 'roku']);
Route::post('ytube/webhook', [YTubeController::class, 'webhook'])->name('ytube.webhook');
Route::post('media/webhook', [HookerController::class, 'webhook'])->name('media.webhook');
Route::post('ipn/jvzoo', [IPNController::class, 'JVZoo'])->name('jvzoo');
Route::post('ipn/wplus', [WPlusController::class, 'WPlus'])->name('wplus');
Route::prefix('monitor/jobs')->group(function () {
    Route::queueMonitor();
});