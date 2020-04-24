<?php

namespace Huyibin\Sms\Events;

use Illuminate\Queue\SerializesModels;

class VerificationCodeSend{


    use SerializesModels;

    public $ret;

    public function __construct($ret)
    {
        $this->ret = $ret;
    }
}
