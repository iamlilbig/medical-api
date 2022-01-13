<?php

namespace App\Helpers;

class Helpers
{

    public static function ConfirmSMS($user,$kavenegar)
    {
        $code = rand(1000,9999);
        $massage = 'کد ورود به نرم افزار ماماتک:';
        $kavenegar->Send(env('KAVENEGAR_NUMBER'),$user->phone,$massage.$code);
        $user->SMSs()->create([
            'user_id' => $user->id,
            'massage' => $massage,
            'code' => $code,
            'massage_type_id' => 1,
        ]);
    }
    public static function sendSMS($user,$attendant,$massage,$kavenegar)
    {
        $kavenegar->Send(env('KAVENEGAR_NUMBER'),$attendant->phone,$massage);
        $user->SMSs()->create([
            'user_id' => $user->id,
            'massage' => $massage,
            'massage_type_id' => 2,
        ]);
    }
    public static function toSnakeCase(array $array)
    {
        $result = [];
        foreach ($array as $key => $value){
            $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
            preg_match_all($pattern, $key, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ?
                    strtolower($match) :
                    lcfirst($match);
            }
            $result[implode('_', $ret)] = $value;
        }
        return $result;
    }
}
