<?php

namespace App\Http\Controllers;

use App\Key;


use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Lib\Calc as Erc;
use App\Lib\Clarion as Clara;
use Illuminate\Support\Facades\File;

class Calc extends Controller
{

    protected function getHistory(Request $request) {
        $histories = Key::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return $histories;
    }

    protected function getErc(Request $request){
        $erc = str_replace(' ', '', $request->get('erc','0000 0000 0000 0000'));
        if(!mb_ereg_match("[A-Fa-f0-9]{16}", $erc)){
            return [
                'left'      => '0000',
                'right'     => '0000',
                'status'    =>'danger',
                'message'   =>'Вы прислали неверные данные'
            ];
        }

        $old = Key::where([
            ['input_data',$erc],
            ['user_id',Auth::user()->id],
        ])->first();

        if($old){
            $left = substr($old->result,0,4);
            $right = substr($old->result,4,4);
            $comment ='';
            if($old->comment){
                $comment = 'К нему был комментарий: '.$old->comment;
            }

            return [
                'left'      => $left,
                'right'     => $right,
                'status'    => 'warning',
                'message'   => 'Вы уже использовали этот erc и получали по нему ключ, Вывожу из истории. <br>' . $comment,
                'sm'        => $old
            ];
        }
        $key = Erc::getErcKey($erc);

        if($key['exception']){
            $ex = '<b> Возможно ключ не подойдет, поизошло исключение, если ключ не подошел, свяжитесь с @GreenPlugin</b>';
        } else {
            $ex = '';
        }
        $sm = Key::create([
            'device_type'=>'erc',
            'result'=>$key['result'],
            'comment'=>$ex,
            'app_type'=>'web',
            'input_data'=>$erc,
            'user_id'=>Auth::user()->id,
        ]);

        $left = substr($key['result'],0,4);
        $right = substr($key['result'],4,4);

        return [
            'left'      => $left,
            'right'     => $right,
            'status'    =>'success',
            'message'   =>'Вы получили ключ разблокировки, осталось ввести его в своем ГУ.<br>'.$ex,
            'sm'        => $sm
        ];


    }

    protected function getClarion(){
        $f = request()->file('ClarionFile');
        if($f->getSize() == 72){
            $file = File::get($f);
            $base64File = base64_encode($file);
            $old = Key::where([
                ['input_data',$base64File],
                ['user_id',Auth::user()->id],
            ])->first();
            if($old){
                return [
                    'code'      =>$old->result,
                    'status'    => 'warning',
                    'message'   => 'Вы уже получали по этому файлу код, Вывожу из истории. Списывать попытку по этому поводу не стану.',
                    'sm'        => $old
                ];
            }

            $cl = new Clara();
            $result = $cl->Decode($file);

            $sm = Key::create([
                'device_type'=>'Clarion',
                'result'=>$result,
                'comment'=>'Это суровый анлокер clarion, он молчалив и прямолинеен, если код найти не удалось он Вам сделает n/a',
                'app_type'=>'web',
                'input_data'=>$base64File,
                'user_id'=>Auth::user()->id,
            ]);

            $unlocks = Auth::user()->unlocks - 1;

            /*User::where('id', Auth::user()->id)->update([
                'unlocks'=> $unlocks
            ]);*/


            return [
                'code'     => $result,
                'status'    =>'success',
                'message'   =>"Вы получили ключ разблокировки, осталось ввести его в своем ГУ. У Вас осталось $unlocks разблокировок Clarion",
                'sm'        => $sm
            ];

        } else{
            return [
                'code'      => '0000',
                'status'    =>'danger',
                'message'   =>'Вы прислали неверные данные'
            ];
        }

    }

    protected function getUnlocks(){
        return ['unlocks'=>Auth::user()->unlocks];
    }


}
