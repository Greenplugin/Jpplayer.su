<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('pages.index');
});

Route::auth();



Route::group(['middleware' => ['auth']], function () {

    Route::get('/telegram-api/testing', 'TelegramApi@testMessage');
    Route::get('/calc', 'TelegramApi@testMessage');
    Route::get('/profile', 'Profile@show');


    Route::post('/save/email', 'Profile@saveEmail');
    Route::post('/save/name', 'Profile@saveName');
    /*Route::get('/profile', function () {
        return view('pages.profile');
    });*/

});

Route::group(['middleware' => ['guest']], function () {

    Route::get('/login', 'UAuth@index');
    Route::get('/register', 'UAuth@registerIndex');
    Route::post('/shadow/auth', 'UAuth@telegramAuth');

});

/*Route::get('/home', 'HomeController@index');*/
Route::get('/telegramx', 'TelegramApi@getWebHook');
Route::post('/telegram-api/lk23jdsfu_LKkj54cxvbihl8-SD9j0hsd', 'TelegramApi@webHook');

