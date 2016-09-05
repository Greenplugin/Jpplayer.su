<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\TelegramMessageLog;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;
use App\Lib;


class TelegramApi extends Controller
{

public function webHook(){
    config()->set('session.driver', 'array');
    $data = request()->get('message');
    $boot = new Lib\TelegramBot();
    $message = $boot->exec($data);

    if($message['callback']){
        $message = $this->$message['callback']($message, $data);
    }

    if($message['reply']){
        Lib\TelegramBot::send($message['text'],$data['from']['id'],$data['message_id']);
    } else {
        Lib\TelegramBot::send($message['text'],$data['from']['id']);
    }

    TelegramMessageLog::insert([ 'value' => json_encode($data)]);

    return('');
}

protected function makeMessage($message,$chat_id, $message_id, $reply){
    return( json_encode([
        'method' => 'sendMessage',
        'reply_to_message_id' => $reply,
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'html',
    ])) ;
}



protected function authThisUser($message,$data){

    $message['text'] = 'Не упал!';
    $current_user = User::where('telegram_id', $data['from']['id'])->first();

    $data['text'] = explode(' ', $data['text'])[1];

    if(!isset($data['from']['username'])){
        $data['from']['username'] = '';
    }
    $avatar = '';

    if($current_user){

        if(!$current_user['avatar']){
            $tgAva = Lib\TelegramBot::getProfilePhoto($data['from']['id']);
            if($tgAva){
                $path = 'avatars/' . $current_user['id'] .'/' . str_random(4) . '_'. time() . '.jpg';
                Storage::disk('user')->put($path, file_get_contents($tgAva));
                //User::where(['id'=>$current_user['id']])->update(['avatar' => '/users/'.$path] );
                $avatar = '/users/'.$path;
            }else{
                $avatar = '';
            }
        }else{
            $avatar = $current_user['avatar'];
        }

        $message['text'] = 'Привет! Тебя авторизовал, можешь вернуться на страницу, она должна была обновиться, если страниица не обновилась - обнови ее вручную.';
        User::where('id', $current_user['id'])->update([
            'telegramAuthKey' => $data['text'],
            'telegram_username' => $data['from']['username'],
            'avatar'=> $avatar
            ]);
    } else {

        $tgAva = Lib\TelegramBot::getProfilePhoto($data['from']['id']);
        if($tgAva){
            $path = 'avatars/' . $current_user['id'] .'/' . str_random(4) . '_'. time() . '.jpg';
            Storage::disk('user')->put($path, file_get_contents($tgAva));
            //User::where(['id'=>$current_user['id']])->update(['avatar' => '/users/'.$path] );
            $avatar = '/users/'.$path;
        }

        $arr = openssl_random_pseudo_bytes(8, $strong);
        $password = bin2hex($arr);

        $message['text'] = "Поздравляем! Вы зарегистрировались на сайте jpplayer.su, Ваш временный пароль <b>$password</b> можете вернуться на страницу, откуда выполняли регистрацию";

        if(!isset($data['from']['first_name'])){
            $data['from']['first_name'] = '';
        }

        if(!isset($data['from']['last_name'])){
            $data['from']['last_name'] = '';
        }


        User::create([
            'telegramAuthKey' => $data['text'],
            'name' => $data['from']['first_name'] . ' ' . $data['from']['last_name'],
            'email' => $data['from']['id'],
            'telegram_id' => $data['from']['id'],
            'avatar' => $avatar,
            'password' => bcrypt($password),
            'active' => 1,
            'unlocks' => 5,
            'telegram_username' => $data['from']['username'],
        ]);
    }

    return $message;
}

}
