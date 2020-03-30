<?php


namespace Huyibin\Sms;

use Huyibin\Sms\Aliyun\AliyunSms;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{



    public function register(){

        $this->app->singleton('sms',function ($app){
            
            switch(config('sms.driver')){

                case 'aliyun':
                    return new AliyunSms;
                
                default:
                    return new AliyunSms;
            }
        });
    }


    public function boot(){


    }
}
