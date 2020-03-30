<?php

namespace Huyibin\Sms;

use Huyibin\Sms\Events\Events\VerificationCodeSend;

abstract class SmsBase implements SmsInterface{



      /**
     * 发送短信验证码发送
     *
     * @param string $phoneNumber
     * @param string $code
     * @return Array
     */
    public  function sendVerificationCode(string $phoneNumber,string $code):Array{
        
        $ret = $this->sendSms($phoneNumber,['code' => $code]);
        event(new VerificationCodeSend($ret));
        return $ret;
    }



    public abstract function sendSms(string $phoneNumber,array $param):Array;
}