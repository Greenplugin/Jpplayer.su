<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TelegramMessageLog;
use League\Flysystem\Config;

class TelegramApi extends Controller
{

public function webHook(){
    $data = request()->get('message');
    TelegramMessageLog::insert([ 'value' => json_encode($data)]);

    if($data['text'] == '/start'){
        $this->send("Привет! Я помогу Тебе разблокировать головное устройство Toyota. Больше я ничего пока не умею 😞, Но меня еще многому скоро научат! Просто пришли мне ERC \n Узнать где взять ERC можно на форуме forum.jpplayer.su",$data['from']['id']);
    } elseif($data['text'] == '/help'){
        $this->send("Я скромный робот, который поможет разблокировать головное устройство по его erc, просто отправь erc в чат и я дам Тебе код разблокировки \n Узнать где взять ERC можно на форуме forum.jpplayer.su",$data['from']['id']);
    } elseif(strtoupper($data['text']) == 'ПРИВЕТ'){
        $this->send("Привет, ну что там, ты нашел ERC? Узнать где взять ERC можно на форуме forum.jpplayer.su",$data['from']['id']);
    }else{
        if(strlen($data['text']) == 16) {
            $this->send($this->send_ERC_key($data['text']),$data['from']['id']) ;
        } else {
            $this->send("Не, меня такому еще не учили. \n Но если что ERC должен быть длиной 16 символов.",$data['from']['id']);
        }
    }


}

public function testMessage(){
    return view('welcome',['data'=>TelegramMessageLog::get(), 'gg' => config('telegram.token')]);
}


protected function send($message,$chat_id){
    $url = "https://api.telegram.org/bot".config('telegram.token')."/sendMessage";
    $content = array(
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'html',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //fix http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec ($ch);
    curl_close ($ch);
}

protected function send_ERC_key($message){
    $erc = $message;
    $hash = '0e010a11';

    if (strlen($erc) == 16) {
        $base = substr($erc, 0, 8);
        $invert = substr($erc, 8, 8);
        $hex_invert = base_convert(strrev(str_pad(base_convert($invert, 16, 2),32,'0',STR_PAD_LEFT)),2,16);
        $hex_invert = str_pad($hex_invert,8,'0',STR_PAD_LEFT);
        $base = str_pad($base,8,'0',STR_PAD_LEFT);
        $hex_result = bin2hex(hex2bin($base) ^ hex2bin($hex_invert));
        $result = dechex((floatval(base_convert($hex_result, 16, 10)) - floatval(base_convert($hash,16, 10)))) ;
        $result = strtoupper(str_pad($result,8,'0',STR_PAD_LEFT));
        return("Ваш код разблокировки: \n <b>$result</b> \n После того как введете его, можете терять, я всегда подскажу новый. \n Удачи!");
    }else{
        return("Неверный код! \n Пришли мне ERC и я Тебе сделаю ключ разблокировки");
    }

}

}
