<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Validator;
use App\Lib;


class Profile extends Controller
{
    public function show(){
        setlocale(LC_TIME, 'Russian');
        Carbon::setLocale(config('app.locale'));

        $child = User::where('parent_linking', Auth::user()->id)->first();

        $data = [
            'regtime' => Auth::user()->created_at->diffForHumans(),
            'child_user' => $child,
        ];

        $value = request()->session()->get('telegramPassKey');

        if(!$value){
            $value = bin2hex(openssl_random_pseudo_bytes(31, $strong));
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
            $key = str_random(64);
            User::where('id', Auth::user()->id)->update(['new_email'=>$data['email'], 'email_confirmation_key'=>$key]);
            if(Auth::user()->telegram_id){
                Lib\TelegramBot::send(
                    'Инициирована смена e-mail учетной записи jpplayer.su',
                    Auth::user()->telegram_id
                );
            }
            $mailData = [
                'url' => config()->get('app.url').'/service/confirm-change-email/'.$key,
                'email' => $data['email']
            ];
            Mail::send('emails.changeEmail', $mailData, function ($message) use ($data) {
                $message->to($data['email'])->subject('Привязка почтового ящика');
            });
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
            if(Auth::user()->telegram_id){
                Lib\TelegramBot::send(
                    'Имя учетной записи jpplayer.su изменено',
                    Auth::user()->telegram_id
                );
            }
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

    public function savePasswordDefault(){
        $data = request()->all();
        $validator = Validator::make($data, [
            'newPassword' => 'required|max:255|min:6',
            'confirmPassword' => 'required|max:255|min:6',
            'defaultPassword' => 'required'
        ]);
        if(!$validator->fails()){
            if($data['newPassword'] != $data['confirmPassword']){
                return [
                    'code'=> false,
                    'result'=> 'danger',
                    'reason'=>'Пароли не совпадают.'
                ];
            }else{
                if(Hash::check($data['defaultPassword'], Auth::user()->password)){
                    User::where('id', Auth::user()->id)->update(['password'=>Hash::make($data['newPassword'])]);
                    if(Auth::user()->telegram_id){
                        Lib\TelegramBot::send(
                            'Пароль учетной записи jpplayer.su изменен.',
                            Auth::user()->telegram_id
                        );
                    }
                    return [
                        'code'=>true,
                        'result' => 'success',
                        'reason' => 'Пароль успешно изменен.'
                    ];
                }else{
                    return [
                        'code'=> false,
                        'result'=> 'danger',
                        'reason'=> 'Старый пароль не подходит'
                    ];
                }
            }
        }else{
            return [
                'code'=> false,
                'result'=> 'danger',
                'reason'=>'Ошибка при смене пароля, Вы ввели некорректные данные.'
            ];
        }
    }

    public function passwordTelegram(){
        $data = request()->all();
        $validator = Validator::make($data, [
            'newPassword' => 'required|max:255|min:6',
            'confirmPassword' => 'required|max:255|min:6'
        ]);
        if(!$validator->fails()){
            if($data['newPassword'] != $data['confirmPassword']){
                return [
                    'code'=> false,
                    'result'=> 'danger',
                    'reason'=>'Пароли не совпадают, как это произошло? а хрен его знает, но Вы можете сейчас сменить пароль в полях, не обновляя страницу и не нажимая кнопку, если введете все правильно, то пароль обновится'
                ];
            }else{
                $token = '_p'.request()->session()->get('telegramPassKey');
                if($token){
                    $current_user = User::where('tg_password_key', $token)->first();
                    if($current_user) {
                        if($current_user['id'] == Auth::user()->id){
                            User::where('id', $current_user['id'])->update([
                                'tg_password_key' => '',
                                'password' => bcrypt($data['newPassword'])
                            ]);
                            if(Auth::user()->telegram_id){
                                Lib\TelegramBot::send(
                                    'Ну вот и все, пароль сменен, я старался и все получилось!',
                                    Auth::user()->telegram_id
                                );
                            }

                            return [
                                'code'=>true,
                                'result' => 'success',
                                'reason' => 'Вы сменили Пароль'
                            ];
                        } else{
                            return [
                                'code'=>false,
                                'result' => 'danger',
                                'reason' => 'Нет, этой уязвимости тут нету'
                            ];
                        }


                    } else{
                        return [
                            'code'=> false
                        ];
                    }
                }
            }
        }else{
            return [
                'code'=> false,
                'result'=> 'danger',
                'reason'=>'Ошибка при смене пароля, Вы ввели некорректные данные. как это произошло? а хрен его знает, но Вы можете сейчас сменить пароль в полях, не обновляя страницу и не нажимая кнопку, если введете все правильно, то пароль обновится'
            ];
        }

    }

    public function changeMail($token){
        if(strlen($token) == 64){
            $user = User::where('email_confirmation_key', $token)->first();
            if($user){
                User::where('id', $user->id)->update([
                    'email'=>$user->new_email,
                    'email_confirmation_key'=>'',
                    'new_email'=>''
                ]);
                return redirect('profile');
            }
            else{
                abort(404);
            }
        } else{
            abort(404);
        }
    }

    public function bindingLink(){
        $left = '_b'.str_random(30);
        $right = str_random(32);

        if(!Auth::user()->telegram_id){
            User::where('id', Auth::user()->id)->update(['local_key'=> $left, 'remote_key'=>$right]);
            return [
                'status'=> true,
                'code'=>true,
                'result' => 'success',
                'reason' => "перейдите по <a href=\"https://telegram.me/jpllayer_bot?start=$left$right\" target='_blank'>этой ссылке</a> для завершения привязки.  <a href=\"https://telegram.me/jpllayer_bot?start=$left$right\" target='_blank'>https://telegram.me/jpllayer_bot?start=$left$right</a>",
                'url' => $left.$right
            ];
        }else{
            return [
                'status'=> true,
                'code'=>true,
                'result' => 'success',
                'reason' => "К Этому аккаунту Telegram уже привязан",
                'url' => $left.$right
            ];
        }


    }

    public function bindingDone(){
        if(Auth::user()->telegram_id){
            return [
                'status'=> true,
                'code'=>true,
            ];
        } else{
            return [
                'status'=> false,
                'code'=>false,
            ];
        }
    }

    public function newAvatar(){
        $extensions = [
            'png'   => true,
            'jpg'   => true,
            'jpeg'  => true,
        ];
        $file = request()->file('avatar');
        if($file){
            $ext = $file->getClientOriginalExtension();
            if(isset($extensions[$ext])){
                $path = 'avatars/' . Auth::user()->id .'/' . str_random(4) . '_'. time() . '.' . $ext;
                Storage::disk('user')->put($path,  File::get($file));
                User::where('id', Auth::user()->id)->update(['avatar'=> '/users/'.$path]);
                return [
                    'code'=>0,
                    'image'=> '/users/'.$path,
                    'result' => 'success',
                    'reason' => 'Вы сменили фото'
                ];
            }else{
                return [
                    'code'=>1,
                    'result' => 'danger',
                    'reason' => 'Этот формат файлов запрещен'
                ];
            }
        }
    }
}
