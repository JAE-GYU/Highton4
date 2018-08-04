<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 회원 관련
Route::group(['prefix' => '/V1', 'namespace' => 'Api\V1'], function(){
    // 회원 컨트롤러
    Route::resource('user','UserController')->except(['index', 'create', 'edit']); 

    // 소셜 로그인
    Route::get('/facebook/redirect', 'SocialAuthController@facebookRedirect')->middleware('web');
    Route::get('/facebook/callback', 'SocialAuthController@facebookCallback')->middleware('web');
    Route::get('/google/redirect', 'SocialAuthController@googleRedirect')->middleware('web');
    Route::get('/google/callback', 'SocialAuthController@googleCallback')->middleware('web');
});

// 로그인
Route::post('/V1/login','API\V1\UserController@login');