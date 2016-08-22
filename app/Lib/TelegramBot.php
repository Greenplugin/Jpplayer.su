<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 19.08.16
 * Time: 11:10
 */

namespace App\Lib;

use App\TelegramMessageLog;
use App\Lib;
use App\User;
use App\Key;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\TelegramApi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegramBot
{
    protected $commands = [
        /*hello block*/
        'привет' => 'hello',
        'здрасте' => 'hello',
        'драсти' => 'hello',
        'как дела?' => 'hello',
        'как дела' => 'hello',
        'как дел' => 'hello',
        'как дел?' => 'hello',

        /*commands*/
        '/start' => 'start',
        '/help' => 'help',

    ];

    protected $regular = [
      "[a-fA-F0-9_-]{16}" => 'calculateErc',
      "/start [a-fA-F0-9_-]{64}" => 'register'
    ];

    public function exec($input){
        $notFound = false;
        if(isset($input['text'])){
            if(isset($this->commands[$input['text']])){
                $f = $this->commands[$input['text']];
                return $this->$f($input);
            } else{
               foreach ($this->regular as $key => $f){
                   if(mb_ereg_match($key, $input['text'])){
                       return $this->$f($input);
                   }
               }
            }
        }
        else{
            return($this->_not_found());
        }
        return($this->_not_found());

    }

    /**
     * @param $userId
     * @param string $size
     * @param bool $current
     * @return string
     */
    public function getProfilePhoto($userId, $size = 'max', $current = true){
        $fileIds = json_decode(file_get_contents("https://api.telegram.org/bot".config('telegram.token')."/getUserProfilePhotos?user_id=".$userId),true);
        $fileId = $fileIds['result']['photos'][0][count($fileIds['result']['photos'][0]) - 1]['file_id'];
        $fileLinks = json_decode(file_get_contents("https://api.telegram.org/bot".config('telegram.token')."/getFile?file_id=".$fileId),true);
        //Log::info(json_encode($fileLinks));
        return "https://api.telegram.org/file/bot".config('telegram.token')."/".$fileLinks['result']['file_path'];
    }

    protected function hello($text){

        return [
            'text'=>"Привет, ну что там, ты нашел ERC? Узнать где взять ERC можно на форуме forum.jpplayer.su",
            'callback' => false,
            'reply' => false
        ];
    }

    protected function start($text){
        $current_user = User::where('telegram_id', $text['from']['id'])->first();
        if(!$current_user){

            if(!isset($text['from']['username'])){
                $text['from']['username'] = '';
            }

            if(!isset($text['from']['first_name'])){
                $text['from']['first_name'] = '';
            }

            if(!isset($text['from']['last_name'])){
                $text['from']['last_name'] = '';
            }

            $arr = openssl_random_pseudo_bytes(8, $strong);
            $password = bin2hex($arr);

            $current_user = User::create([
                'name' => $text['from']['first_name'] . ' ' . $text['from']['last_name'],
                'telegram_id' => $text['from']['id'],
                'email' => $text['from']['id'],
                'telegram_username' => $text['from']['username'],
                'password' => bcrypt($password),
            ]);

            $tgAva = $this->getProfilePhoto($text['from']['id']);
            Storage::disk('user')->put('avatars/'.$current_user['id'].'/avatar.jpg', file_get_contents($tgAva));
            User::where(['id'=>$current_user['id']])->update(['avatar' => '/users/avatars/'.$current_user['id'].'/avatar.jpg'] );

            return [
                'text'=>"Привет, ".$current_user['name'].", Ну вот Ты и зарегался на сайте jpplayer, я поставил Тебе временный пароль \"$password\", его Ты сможешь сменить в настройках профиля или написав мне \"Новый пароль %твой пароль%\" \n\n Я помогу Тебе разблокировать головное устройство Toyota. Больше я ничего пока не умею 😞, Но меня еще многому скоро научат! Просто пришли мне ERC \n\n Узнать где взять ERC можно на форуме forum.jpplayer.su",
                //'text'=>json_encode($text),
                'callback' => false,
                'reply' => false
            ];
        } else {
            $tgAva = $this->getProfilePhoto($text['from']['id']);
            Storage::disk('user')->put('avatars/'.$current_user['id'].'/avatar.jpg', file_get_contents($tgAva));
            User::where(['id'=>$current_user['id']])->update(['avatar' => '/users/avatars/'.$current_user['id'].'/avatar.jpg'] );

            return [
                'text'=>"Привет! Я помогу Тебе разблокировать головное устройство Toyota. Больше я ничего пока не умею 😞, Но меня еще многому скоро научат! Просто пришли мне ERC \n Узнать где взять ERC можно на форуме forum.jpplayer.su \n и да, теперь Ты зарегистрирован на сайте",
                'callback' => false,
                'reply' => false
            ];
        }

    }

    protected function help($text){
        return [
            'text'=>"Я скромный робот, который поможет разблокировать головное устройство по его erc, просто отправь erc в чат и я дам Тебе код разблокировки \n Узнать где взять ERC можно на форуме forum.jpplayer.su",
            'callback' => false,
            'reply' => false
        ];
    }

    protected function _not_found(){
        return [
            'text'=>"К такому меня жизнь не готовила. \n Но если что, ERC должен быть длиной 16 символов.",
            'callback' => false,
            'reply' => false
        ];
    }

    protected function register($text){
        return [
            'text'=>"Привет! Я помогу Тебе разблокировать головное устройство Toyota. Больше я ничего пока не умею 😞, Но меня еще многому скоро научат! Просто пришли мне ERC \n Узнать где взять ERC можно на форуме forum.jpplayer.su, и да, на сайте Ты зарегистрирован, можешь обновить страницу, если она еще сама не обновилась",
            'callback' => 'authThisUser',
            'reply' => false
        ];
    }

    protected function calculateErc($text){
        $calc = new Lib\Calc();
        $current_user = User::where('telegram_id', $text['from']['id'])->first();

        if($current_user){
            $key = $calc->getErcKey($text['text']);



            if($key['exception']){
                $ex = '<b> Возможно ключ не подойдет, поизошло исключение, если ключ не подошел, свяжитесь с @GreenPlugin</b>';
            } else {
                $ex = '';
            }

            //TelegramMessageLog::insert([ 'value' => json_encode($current_user)]);

            Key::create([
                'device_type'=>'erc',
                'result'=>$key['result'],
                'comment'=>$ex,
                'app_type'=>'telegram',
                'input_data'=>$text['text'],
                'user_id'=>$current_user['id'],
            ]);

            $key = $key['result'];
            if($key){
                return [
                    'text'=>"Я сгенерировал ключик, теперь можно попробовать его ввести в устройстве. Напоминаю, что с Вопросами Вы можете обратиться на форум forum.jpplayer.su \n --------- Ключ -------- \n <strong>$key</strong> \n --------- Ключ -------- \n $ex",
                    'callback' => false,
                    'reply' => false
                ];
            }

            return [
                'text'=>"Не удалось сгенерировать ключ 😞",
                'callback' => false,
                'reply' => false
            ];
        } else{
            return [
                'text'=>"Вы не авторизованы, выполните команду /start",
                'callback' => false,
                'reply' => false
            ];
        }


    }

}