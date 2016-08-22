<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Illuminate\Routing\Controller;


class UAuth extends Controller
{
    public function index(){
        $data = [
            'active'=>1
        ];

        if (!Auth::check()) {
            $value = request()->session()->get('telegramRegKey');
        } else {
            $value = false;
        }

        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(32, $strong));
            request()->session()->put('telegramRegKey', $value);
        }
        $data['telegram_key'] = $value;

        return view('pages.auth', $data);
    }

    public function calcMiddle(){
        $data = [
            'active'=>1,
            'message' => 'Для использования калькулятора необходимо войти'
        ];
        if (!Auth::check()) {
            $value = request()->session()->get('telegramRegKey');
        } else {
            $value = false;
        }
        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(32, $strong));
            request()->session()->put('telegramRegKey', $value);
        }
        $data['telegram_key'] = $value;
        return view('pages.auth', $data);
    }

    public function registerIndex(){
        $data = [
            'active'=>0
        ];

        if (!Auth::check()) {
            $value = request()->session()->get('telegramRegKey');
        } else {
            $value = false;
        }
        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(32, $strong));
            request()->session()->put('telegramRegKey', $value);
        }
        $data['telegram_key'] = $value;
        return view('pages.auth', $data);
    }

    public function telegramAuth(){
        $token = request()->get('auth_token');
        if($token){
            $current_user = User::where('telegramAuthKey', $token)->first();
           if($current_user) {
               Auth::loginUsingId($current_user['id'], true);
               User::where('id', $current_user['id'])->update([
                   'telegramAuthKey' => '',
               ]);
               return $token;
           } else{
               return 0;
           }
        }
    }

}
