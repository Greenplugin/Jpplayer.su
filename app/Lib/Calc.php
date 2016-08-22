<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 19.08.16
 * Time: 11:40
 */

namespace app\Lib;


class Calc
{

    public function getErcKey($erc){
        $hash = '0e010a11';

        try{
            if (strlen($erc) == 16) {
                $exception = false;
                $base = substr($erc, 0, 8);
                $invert = substr($erc, 8, 8);
                $hex_invert = base_convert(strrev(str_pad(base_convert($invert, 16, 2),32,'0',STR_PAD_LEFT)),2,16);
                $hex_invert = str_pad($hex_invert,8,'0',STR_PAD_LEFT);
                $base = str_pad($base,8,'0',STR_PAD_LEFT);
                $hex_result = bin2hex(hex2bin($base) ^ hex2bin($hex_invert));
                $result = dechex((floatval(base_convert($hex_result, 16, 10)) - floatval(base_convert($hash,16, 10)))) ;
                $result = strtoupper(str_pad($result,8,'0',STR_PAD_LEFT));
                if(strlen($result)>8){
                    $result = substr($result, -8);
                    $exception = true;
                }

                return(['result'=>$result, 'exception'=>$exception]);
            }else{
                return(false);
            }
        } catch (Exception $e){
            return(false);
        }
    }

}