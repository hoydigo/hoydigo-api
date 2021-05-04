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
Route::prefix('/auth')->group(function() {
    Route::post('/get_token', 'App\Http\Controllers\api\v1\AuthController@getToken');
    Route::post('/register', 'App\Http\Controllers\api\v1\AuthController@register')->middleware(['auth:api', 'scopes:auth:register']);
});

Route::prefix('/admin')->group(function () {
    Route::get('/political-party', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@index')->middleware(['auth:api', 'scopes:admin:political-party:list']);
    Route::post('/political-party', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@store')->middleware(['auth:api', 'scopes:admin:political-party:create']);
});
