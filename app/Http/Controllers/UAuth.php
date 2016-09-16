<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UAuth extends Controller
{
    use ValidatesRequests, AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected function generateRegKey(){
        if (!Auth::check()) {
            $value = request()->session()->get('telegramRegKey');
        } else {
            $value = false;
        }

        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(32, $strong));
            request()->session()->put('telegramRegKey', $value);
        }
        return $value;
    }
    public function index(){
        $data = [
            'active'=>1
        ];
        $data['telegram_key'] = $this->generateRegKey();
        return view('pages.auth', $data);
    }

    public function calcMiddle(){

        $data = [
            'active'=>1,
            'message' => 'Для использования калькулятора необходимо войти'
        ];

        $data['telegram_key'] = $this->generateRegKey();
        return view('pages.auth', $data);
    }

    public function registerIndex(){
        $data = [
            'active'=>0
        ];

        $data['telegram_key'] = $this->generateRegKey();
        return view('pages.auth', $data);
    }

    public function telegramAuth(){
        //$token = request()->get('auth_token');
        $token = request()->session()->get('telegramRegKey');
        if($token){
            $current_user = User::where('telegramAuthKey', $token)->first();
           if($current_user) {
               Auth::loginUsingId($current_user['id'], true);
               $current_user->telegramAuthKey = '';
               $current_user->save();
               return $token;
           } else{
               return 0;
           }
        } else {
            return 0;
        }
    }

    protected function create(Request $request){

        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1, 'parent_linking' => 0])) {
            return redirect()->intended('profile');
        } else {
            return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
        }
    }

    protected function registration(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|same:password',
        ]);

        $confirmationKey = str_random(64);

        $mailData = [
            'url' => config()->get('app.url').'/service/confirm-email/'.$confirmationKey,
            'email' => $request['email'],
            'site'  => config()->get('app.url')
        ];

        Mail::send('emails.registerEmail', $mailData, function ($message) use ($request) {
            $message->to($request['email'])->subject('Регистрация на сайте JpPlayer.su');
        });

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'active' => 0,
            'email_confirmation_key' => $confirmationKey,
        ]);

        $m =$request['email'];
        $data = [
            'header' => 'Регистрация успешно пройдена',
            'notify' => 'После завершения регистрации можно будет использовать оба калькулятора',
            'button' => [
                'href'=>url('/home'),
                'text'=>'Вернуться на сайт'
            ],
            'description' => "Вы только что прошли регистрацию на сайте, Вам на E-mail $m отправлено письмо для завершения регистрации. Вы сможете войти на сайт после того как подтвердите свой почтовый ящик. Спасибо а ргеистрацию.",
        ];

        return view('pages.message', $data);
    }

    protected function confirm($key){
        $current_user = User::where('email_confirmation_key', $key)->first();

        if($current_user){
            $current_user->active = 1;
            $current_user->email_confirmation_key = '';
            $current_user->unlocks = 3;
            $current_user->save();
            Auth::loginUsingId($current_user->id, true);
            $data = [
                'header' => 'Вы успешно зарегистрировались',
                'notify' => 'Теперь можно пользоваться калькулятором',
                'button' => [
                    'href'=>url('/profile'),
                    'text'=>'Перейти в свой профиль'
                ],
                'description' => "<p style=\"text-align: center\">Вам начислено 3 разблокировки для clarion, если Вам этого мало, в профиле Вы можете привязать аккаунт telegram чтобы увеличить лимит, или попросить об увеличении лимита на форуме. Количество разблокировок erc не ограничено</p>",
            ];

            return view('pages.message', $data);
        }else{
            abort(404);
        }
    }


}
