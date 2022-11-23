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

// Admin routesup

Route::prefix('/admin')->group(function () {
    Route::get('/political-party', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@index')->middleware(['auth:api', 'scopes:admin:political-party:list']);
    Route::post('/political-party', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@store')->middleware(['auth:api', 'scopes:admin:political-party:create']);
    Route::get('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@show')->middleware(['auth:api', 'scopes:admin:political-party:get']);
    Route::patch('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@update')->middleware(['auth:api', 'scopes:admin:political-party:update']);
    Route::delete('/political-party/{political_party_id}', 'App\Http\Controllers\api\v1\admin\PoliticalPartyController@destroy')->middleware(['auth:api', 'scopes:admin:political-party:delete']);

    Route::get('/position', 'App\Http\Controllers\api\v1\admin\PositionController@index')->middleware(['auth:api', 'scopes:admin:position:list']);
    Route::post('/position', 'App\Http\Controllers\api\v1\admin\PositionController@store')->middleware(['auth:api', 'scopes:admin:position:create']);
    Route::get('/position/{position_id}', 'App\Http\Controllers\api\v1\admin\PositionController@show')->middleware(['auth:api', 'scopes:admin:position:get']);
    Route::patch('/position/{position_id}', 'App\Http\Controllers\api\v1\admin\PositionController@update')->middleware(['auth:api', 'scopes:admin:position:update']);
    Route::delete('/position/{position_id}', 'App\Http\Controllers\api\v1\admin\PositionController@destroy')->middleware(['auth:api', 'scopes:admin:position:delete']);

    Route::get('/influencer', 'App\Http\Controllers\api\v1\admin\InfluencerController@index')->middleware(['auth:api', 'scopes:admin:influencer:list']);
    Route::post('/influencer', 'App\Http\Controllers\api\v1\admin\InfluencerController@store')->middleware(['auth:api', 'scopes:admin:influencer:create']);
    Route::get('/influencer/{influencer_id}', 'App\Http\Controllers\api\v1\admin\InfluencerController@show')->middleware(['auth:api', 'scopes:admin:influencer:get']);
    Route::patch('/influencer/{influencer_id}', 'App\Http\Controllers\api\v1\admin\InfluencerController@update')->middleware(['auth:api', 'scopes:admin:influencer:update']);
    Route::delete('/influencer/{influencer_id}', 'App\Http\Controllers\api\v1\admin\InfluencerController@destroy')->middleware(['auth:api', 'scopes:admin:influencer:delete']);
    Route::post('/influencer/{influencer_id}/pull-twitter-data', 'App\Http\Controllers\api\v1\admin\InfluencerController@pullTwitterData')->middleware(['auth:api', 'scopes:admin:influencer:create']);
});
