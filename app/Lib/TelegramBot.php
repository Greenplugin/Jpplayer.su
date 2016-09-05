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
use Illuminate\Support\Facades\Auth;
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
      "/start [a-fA-F0-9]{64}" => 'register',
      "/start _p[a-fA-F0-9]{62}" => 'changePassword',
      "/start _b[a-zA-Z0-9]{62}" => 'bindTelegramToAccount'
    ];

    protected $fileSwitcher = [
        '*:72' => 'clarionGen'
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
        elseif (isset($input['document'])){
            foreach ($this->fileSwitcher as $key=>$func){
                $k = explode(':',$key); $mime = $k[0]; $length = $k[1];
                if($mime =='*'){
                   $mime = $input['document']['mime_type'];
                }
                if($input['document']['mime_type'] == $mime && $input['document']['file_size'] == $length){
                    $input['document']['url'] = $this->getFileLinkFromTelegram($input['document']['file_id']);
                    return $this->$func($input);
                }
            }
            return[
                'text'=>"Если Ты хочешь чтобы я разблокировал Clarion, то высылай мне файл CL_SCODE.SCR не упакованный и убедись что его размер 72 байта, иначе я его просто проигнорирую, так же как сделал сейчас.",
                'callback' => false,
                'reply' => false
            ];
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
    public static function getProfilePhoto($userId, $size = 'max', $current = true){
        $fileIds = json_decode(file_get_contents("https://api.telegram.org/bot".config('telegram.token')."/getUserProfilePhotos?user_id=".$userId),true);
        if(isset($fileIds['result']['photos'][0])){
            $fileId = $fileIds['result']['photos'][0][count($fileIds['result']['photos'][0]) - 1]['file_id'];
            $fileLinks = json_decode(file_get_contents("https://api.telegram.org/bot".config('telegram.token')."/getFile?file_id=".$fileId),true);
            //Log::info(json_encode($fileLinks));
            return "https://api.telegram.org/file/bot".config('telegram.token')."/".$fileLinks['result']['file_path'];
        }
        return false;

    }

    public function getFileLinkFromTelegram($fileId){
        $fileLinks = json_decode(file_get_contents("https://api.telegram.org/bot".config('telegram.token')."/getFile?file_id=".$fileId),true);
        return "https://api.telegram.org/file/bot".config('telegram.token')."/".$fileLinks['result']['file_path'];
    }

    public static function send($message,$chat_id = false, $reply = false){
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

            $avatar = '';
            $tgAva = $this->getProfilePhoto($text['from']['id']);
            if($tgAva){
                $path = 'avatars/' . $current_user['id'] .'/' . str_random(4) . '_'. time() . '.jpg';
                Storage::disk('user')->put($path, file_get_contents($tgAva));
                //User::where(['id'=>$current_user['id']])->update(['avatar' => '/users/'.$path] );
                $avatar = '/users/'.$path;
            }

            $current_user = User::create([
                'name' => $text['from']['first_name'] . ' ' . $text['from']['last_name'],
                'telegram_id' => $text['from']['id'],
                'email' => $text['from']['id'],
                'telegram_username' => $text['from']['username'],
                'avatar' => $avatar,
                'active' => 1,
                'unlocks' => 5,
                'password' => bcrypt($password),
            ]);

            return [
                'text'=>"Привет, ".$current_user['name'].", Ну вот Ты и зарегался на сайте jpplayer, я поставил Тебе временный пароль \"$password\", его Ты сможешь сменить в настройках профиля.\n\n Я помогу Тебе разблокировать головное устройство Toyota или Clarion! Просто пришли мне ERC код или SCR файл \n\n Узнать где взять ERC код или SCR файл можно на форуме forum.jpplayer.su",
                //'text'=>json_encode($text),
                'callback' => false,
                'reply' => false
            ];
        } else {
            $tgAva = $this->getProfilePhoto($text['from']['id']);

            if(!$current_user['avatar']){
                if($tgAva){
                    $path = 'avatars/' . $current_user['id'] .'/' . str_random(4) . '_'. time() . '.jpg';
                    Storage::disk('user')->put($path, file_get_contents($tgAva));
                    $avatar = '/users/'.$path;
                }else{
                    $avatar = '';
                }
            }else{
                $avatar = $current_user['avatar'];
            }

            User::where('id', $current_user['id'])->update([
                'active' => 1,
                'avatar'=> $avatar,
            ]);

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
            'text'=>"К такому меня жизнь не готовила. \n Но если что, ERC должен быть длиной 16 символов. \n А чтобы получить ключ для Clarion нужно отправить мне файл <b>CL_SCODE.SCR</b>. \n Учти что на разблокировку Clarion существуют лимиты",
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

    protected function changePassword($text){
        $current_user = User::where('telegram_id', $text['from']['id'])->first();
        $text['text'] = explode(' ', $text['text'])[1];
        if($current_user){
            User::where('id', $current_user['id'])->update([
                'tg_password_key' => $text['text']
            ]);
            return [
                'text'=>"Смена пароля инициирована, я сообщу когда пароль сменится.\n Кстати да, не обновляй страницу, пока я не разрешу.",
                'callback' => false,
                'reply' => false
            ];
        }else{
            return [
                'text'=>"О нет! такого пользователя не существует! Ты понимаешь? Ты не существуешь!",
                'callback' => false,
                'reply' => false
            ];
        }
    }

    protected function bindTelegramToAccount($text){
        $key = explode(' ', $text['text'])[1];
        $left = substr($key, 0, 32);
        $right = substr($key, 32, 32);
        $current_user = User::where('telegram_id', $left)->first();

        if($current_user) {
            $tgUser = User::where('telegram_id', $text['from']['id'])->first();
            if (!$tgUser) {

                if(!$current_user['avatar']){
                    $tgAva = $this->getProfilePhoto($text['from']['id']);
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


                User::where('id', $current_user['id'])->update([
                    'local_key'         => '',
                    'remote_key'         => '',
                    'telegram_id'       => $text['from']['id'],
                    'telegram_username' => $text['from']['username'],
                    'unlocks'           => $current_user['unlocks'] + 5,
                    'avatar'            => $avatar,
                ]);

                return [
                    'text' => "Я привязал Твой Telegram к обычному аккаунту, что-нибудь еще?",
                    'callback' => false,
                    'reply' => false
                ];
            } else{

                if(!$current_user['avatar']){
                    $tgAva = $this->getProfilePhoto($text['from']['id']);
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

                User::where('id', $tgUser['id'])->update([
                    'local_key'         => '',
                    'remote_key'         => '',
                    'telegram_id' => $text['from']['id'].$current_user['id'],
                    'parent_linking' => $current_user['id'],
                    'unlocks' => 0
                ]);

                Key::where('user_id', $tgUser['id'])->update(['user_id' => $current_user['id']]);

                User::where('id', $current_user['id'])->update([
                    'local_key'         => '',
                    'remote_key'         => '',
                    'telegram_id'       => $text['from']['id'],
                    'telegram_username' => $text['from']['username'],
                    'avatar'            => $avatar,
                    'unlocks'           => $current_user['unlocks'] +  $tgUser['unlocks'],
                ]);


                return [
                    'text' => "Я связал Два аккаунта, теперь вся история будет вестись в аккаунте, к которому привязан этот telegram",
                    'callback' => false,
                    'reply' => false
                ];
            }
        }


        return [
            'text'=>"Я не нашел пользователя, попробуй еще раз.",
            'callback' => false,
            'reply' => false
        ];
    }

    protected function clarionGen($input){
        $current_user = User::where('telegram_id', $input['from']['id'])->first();
        if($current_user){
            if($current_user->unlocks > 0){
                $clarion = new Lib\Clarion();
                $data = file_get_contents($input['document']['url']);
                $result = $clarion->Decode($data);
                //$result = $data;
                $unlocks = $current_user->unlocks - 1;

                /*User::where('id', $current_user->id)->update([
                    'unlocks'=> $unlocks
                ]);*/

                Key::create([
                    'device_type'=>'Clarion',
                    'result'=>$result,
                    'comment'=>'Это суровый анлокер clarion, он молчалив и прямолинеен, если код найти не удалось он Вам сделает n/a',
                    'app_type'=>'telegram',
                    'input_data'=>base64_encode($data),
                    'user_id'=>$current_user['id'],
                ]);

                return [
                    'text'=>"Я сгенерировал код для Твоего Clarion \n ------- код ------- \n <b>$result</b> \n ------- код ------- \n Попробуй, должен подойти. А если не подойдет - то пиши об этом на форум (forum.jpplayer.su). \n И ксати, у Тебя осталось <b>$unlocks</b> разблокировок.",
                    'callback' => false,
                    'reply' => false
                ];
            }
            else{
                return [
                    'text'=>"Ты исчерпал лимит на разблокировку, можeшь попросить на форуме чтобы дали анлоков или в личку @Greenplugin тут в телеграм",
                    'callback' => false,
                    'reply' => false
                ];
            }
        } else{
            return [
                'text'=>"Вы не авторизованы, выполните команду /start",
                'callback' => false,
                'reply' => false
            ];
        }

    }
}