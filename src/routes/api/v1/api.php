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
    Route::get('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@show')->middleware(['auth:api', 'scopes:admin:political-party:get']);
    Route::patch('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@update')->middleware(['auth:api', 'scopes:admin:political-party:update']);
    Route::delete('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@destroy')->middleware(['auth:api', 'scopes:admin:political-party:delete']);
});
