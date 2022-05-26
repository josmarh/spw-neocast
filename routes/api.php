<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\VideoController;

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
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/personal-info', [AuthController::class, 'updateUser']);
    Route::put('/password/update', [AuthController::class, 'updatePassword']);
    Route::post('/uploads', [UploadsController::class, 'fileUpload']);

    Route::get('/videos', [VideoController::class, 'index']);
    Route::group(['prefix' => 'video'], function () {
        Route::put('update', [VideoController::class, 'update']);
        Route::get('download/{id}', [VideoController::class, 'download']);
        Route::delete('delete/{id}', [VideoController::class, 'delete']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/video/show/{str}', [VideoController::class, 'show']);