<?php


namespace Huyibin\Sms;


use Illuminate\Support\Facades\Facade;
/**
 * @method static array sendVerificationCode(string $phoneNumber,string $code)
 * @see \Huyibin\Sms\SmsInterface
 */
class Sms extends Facade
{
    protected static function getFacadeAccessor()
    {

        return 'sms';
    }

}
