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

Route::get('/thank-you', function () {
    return view('pages.index');
});

Route::get('/home', function () {
    return view('pages.index');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::auth();

Route::post('/donate/callback', 'TelegramApi@paymentCallback');


Route::group(['middleware' => ['auth']], function () {

    Route::get('/calc', function () {
        return view('pages.calc');
    });


    Route::get('?route=calc', function () {
        return view('pages.calc');
    });

    Route::get('/history/get', 'Calc@getHistory');

    Route::get('/profile', 'Profile@show');

    Route::get('/calc/unlocks', 'Calc@getUnlocks');

    Route::post('/calc/Erc', 'Calc@getErc');
    Route::post('/calc/clarion', 'Calc@getClarion');

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

    Route::get('/service/confirm-email/{token}', 'UAuth@confirm');

    Route::get('/login', 'UAuth@index');
    Route::get('/register', 'UAuth@registerIndex');

    Route::post('/login', 'UAuth@create');
    Route::post('/register', 'UAuth@registration');

    Route::post('/shadow/auth', 'UAuth@telegramAuth');
});

/*Route::get('/home', 'HomeController@index');*/
//Route::get('/telegramx', 'TelegramApi@getWebHook');
Route::post('/telegram-api/'.config()->get('telegram.web_hook'), 'TelegramApi@webHook');

