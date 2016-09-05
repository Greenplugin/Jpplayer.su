<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;


class UAuth extends Controller
{
    use ValidatesRequests, AuthenticatesAndRegistersUsers, ThrottlesLogins;

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
        //$token = request()->get('auth_token');
        $token = request()->session()->get('telegramRegKey');
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

    protected function create(Request $request){

        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {
            return redirect()->intended('profile');
        } else {
            return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
        }
    }


}
