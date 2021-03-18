<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', [\App\Http\Controllers\Api\Oauth2::class, 'login']);
Route::post('/regis', [\App\Http\Controllers\Api\Oauth2::class, 'regis']);
Route::get('banner/get', [\App\Http\Controllers\Api\BannerController::class, 'get']);
Route::middleware(['auth:sanctum', 'json.response', 'cors'])->group(function () {
    Route::get('isAuthenticated', function () {
        return ["message" => "Authenticated"];
    });
    Route::prefix('banner')->group(function () {
        Route::post('save', [\App\Http\Controllers\Api\BannerController::class, 'save']);
    });
});
