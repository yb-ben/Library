<?php
namespace Huyibin\Sms;

interface SmsInterface{


    public function sendVerificationCode(string $phoneNumber,string $code);


}