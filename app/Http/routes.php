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

Route::get('/home', function () {
    return view('pages.index');
});

Route::auth();



Route::group(['middleware' => ['auth']], function () {

    Route::get('/calc', function () {
        return view('pages.calc');
    });

    Route::get('/history/get', 'Calc@getHistory');

    Route::get('/profile', 'Profile@show');

    Route::post('/profile/new-avatar', 'Profile@newAvatar');


    Route::post('/save/email', 'Profile@saveEmail');
    Route::post('/save/name', 'Profile@saveName');
    Route::post('/save/passwordDefault', 'Profile@savePasswordDefault');
    Route::post('/save/passwordTelegram', 'Profile@passwordTelegram');

    Route::get('/save/get-telegram-binding-link', 'Profile@bindingLink');
    Route::get('/save/get-telegram-binding-done', 'Profile@bindingDone');

    Route::get('/service/confirm-change-email/{token}', 'Profile@changeMail');
    /*Route::get('/profile', function () {
        return view('pages.profile');
    });*/

});

Route::group(['middleware' => ['guest']], function () {


    Route::get('/login', 'UAuth@index');
    Route::get('/register', 'UAuth@registerIndex');
    Route::post('/shadow/auth', 'UAuth@telegramAuth');

    Route::post('/login', 'UAuth@create');

});

/*Route::get('/home', 'HomeController@index');*/
Route::get('/telegramx', 'TelegramApi@getWebHook');
Route::post('/telegram-api/lk23jdsfu_LKkj54cxvbihl8-SD9j0hsd', 'TelegramApi@webHook');

