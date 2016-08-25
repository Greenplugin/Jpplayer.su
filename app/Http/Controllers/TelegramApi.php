<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\TelegramMessageLog;
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
        $this->send($message['text'],$data['from']['id'],$data['message_id']);
    } else {
        $this->send($message['text'],$data['from']['id']);
    }

    TelegramMessageLog::insert([ 'value' => json_encode($data)]);

    return('');
}

public function testMessage(){
    return view('welcome',['data'=>TelegramMessageLog::get(), 'gg' => config('telegram.token')]);
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

public function send($message,$chat_id = false, $reply = false){
    $url = "https://api.telegram.org/bot".config('telegram.token')."/sendMessage";

    if(!is_array($message)){
        $content = array(
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
        );
    }
    else{
        $content = $message;
    }

    if($reply){
        $content['reply_to_message_id'] = $reply;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //fix http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec ($ch);
    curl_close ($ch);
    return $response;
}

protected function authThisUser($message,$data){

    $message['text'] = 'Не упал!';
    $current_user = User::where('telegram_id', $data['from']['id'])->first();

    $data['text'] = explode(' ', $data['text'])[1];

    if(!isset($data['from']['username'])){
        $data['from']['username'] = '';
    }

    if($current_user){
        $message['text'] = 'Вы авторизовались на сайте jpplayer.su, можете вернуться на страницу, она должна была обновиться.';
        User::where('id', $current_user['id'])->update([
            'telegramAuthKey' => $data['text'],
            'telegram_username' => $data['from']['username'],
            ]);
    } else {

        $Avatar = $this->send([
            'chat_id' => $data['from']['id'],
            'chat_id' => $data['from']['id'],

        ]);
        $message['text'] = 'Поздравляем! Вы зарегистрировались на сайте jpplayer.su, можете вернуться на страницу, откуда выполняли регистрацию';

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
            'telegram_username' => $data['from']['username'],
        ]);
    }

    return $message;
}

}
