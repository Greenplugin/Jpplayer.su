<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;


class Profile extends Controller
{
    public function show(){
        setlocale(LC_TIME, 'Russian');
        Carbon::setLocale(config('app.locale'));

        $data = [
            'regtime' => Auth::user()->created_at->diffForHumans()
        ];

        $value = request()->session()->get('telegramPassKey');

        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(16, $strong));
            request()->session()->put('telegramPassKey', $value);
        }

        $data['telegram_key'] = $value;


        return view('pages.profile', $data);
    }

    public function saveEmail(){
        $data = request()->all();
        $validator = Validator::make($data, [
            'email' => 'required|email|max:255|unique:users'
        ]);
        if(!$validator->fails()){
            User::where('id', Auth::user()->id)->update(['new_email'=>$data['email']]);
            return [
                'code'=>true,
                'result' => 'success',
                'reason' => 'Смена Email успешно инициирована, Вам на почту отправлено письмо для подтверждения нового адреса'
            ];
        }else{
            return [
                'code'=> false,
                'result'=> 'danger',
                'reason'=>$validator->messages()->get('email')
            ];
        }
    }

    public function saveName(){
        $data = request()->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255|min:2'
        ]);
        if(!$validator->fails()){
            User::where('id', Auth::user()->id)->update(['name'=>$data['name']]);
            return [
                'code'=>true,
                'result' => 'success',
                'reason' => 'Вы сменили имя'
            ];
        }else{
            return [
                'code'=> false,
                'result'=> 'danger',
                'reason'=>$validator->messages()->get('name')
            ];
        }
    }
}
