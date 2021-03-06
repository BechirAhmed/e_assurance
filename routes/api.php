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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('auth/login', 'Api\AuthController@login');
    Route::post('auth/register', 'Api\AuthController@register');
    
    Route::get('auth/get_user', 'Api\AuthController@getUser');
    Route::post('auth/update_device', 'Api\AuthController@updateDevice');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('auth/logout', 'Api\AuthController@logout');
    Route::resource('assurances', 'Api\AssuranceController');
    Route::get('user/assurances', 'Api\AssuranceController@userAssurances');
});