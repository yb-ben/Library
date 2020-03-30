<?php

namespace Huyibin\VerificationCode;


use Illuminate\Support\ServiceProvider;


class VCodeServiceProvider extends ServiceProvider {


    public function register(){

        $this->app->singleton('VCode',function ($app){
            return new VCode;
        });
    }


    
    public function boot(){


    }
}