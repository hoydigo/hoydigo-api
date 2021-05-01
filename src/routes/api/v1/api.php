<?php

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

// Auth
Route::prefix('/auth')->group( function() {
    Route::post('/get_token', 'App\Http\Controllers\api\v1\AuthController@getToken');
    Route::post('/register', 'App\Http\Controllers\api\v1\AuthController@register')->middleware(['auth:api', 'scopes:user:register']);
});
