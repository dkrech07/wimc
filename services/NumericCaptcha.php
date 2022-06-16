<?php

namespace app\services;

use yii\captcha\CaptchaAction as DefaultCaptchaAction;

class NumericCaptcha extends DefaultCaptchaAction
{
    protected function generateVerifyCode()
    {
        //Длина
        $length = 5;
        //Цифры, которые используются при генерации
        $digits = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $digits[mt_rand(0, 9)];
        }
        return $code;
    }
}
