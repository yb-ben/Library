<?php


namespace Huyibin\VerificationCode;

use Illuminate\Support\Facades\Redis;

class VCode{

    protected  $str = '0123456789';

    protected $key = 'vcode';

    protected $expire = 300;

    public function __construct($str = null)
    {

        $str && ($this->str = $str);
    }



    public function generate($size = 6){

        $len = mb_strlen($this->str);
        $s = '';
            for($i = 0 ; $i < $size; $i++){
                $p = random_int(0,$len);
                $s .= $this->str{$p};
            }
        return $s;
    }

    public function generateAndStore($identifier,$size = 6){
          
        for($j = 0;$j < 3; $j++){
            $s = $this->generate($size);
            if($this->store($identifier,$s)){
                return $s;
            }
        }
        throw new \Exception('failed to generate vcode!');
    }


    public  function store($identifier,$code){

       return Redis::set($this->key.':'.$identifier,$code, $this->expire);
    
    }

    public function check($identifier,$code){
        $key = $this->key.':'.$identifier;
        $c = Redis::get($key);
        if($c === $code){
            Redis::del($key);
            return true;
        }
        return false;
    }

}