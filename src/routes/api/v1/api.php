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

// Users
Route::prefix('/user')->group( function() {

    Route::post('/get_token', 'App\Http\Controllers\api\v1\AuthController@getToken');

    Route::post('/register', 'App\Http\Controllers\api\v1\AuthController@register')
        ->middleware(['auth:api', 'scopes:user:register']);;

    Route::get('/all', 'App\Http\Controllers\api\v1\user\UserController@index')
        ->middleware(['auth:api', 'scopes:test:get-users']);;
});
