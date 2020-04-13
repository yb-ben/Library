<?php


namespace Huyibin\VerificationCode;

use Illuminate\Support\Facades\Redis;

class VCode{
    /**
     * 允许的字符集
     * @var string
     */
    protected  $str;

    /**
     * 键前缀
     * @var string
     */
    protected $key ;

    /**
     * 过期时间
     * @var integer
     */
    protected $expire;

    public function __construct($str = null,$key = null)
    {
        $this->str = $str?:'0123456789';
        $this->key = empty($key)?env('VCODE_KEY','vcode'):$key;
        $this->expire = env('VCODE_EXPIRE',300);
    }


    /**
     * 生成验证码
     * @param int $size
     * @return string
     * @throws \Exception
     */
    public function generate($size = 6){

        $len = mb_strlen($this->str)-1;
        $s = '';
            for($i = 0 ; $i < $size; $i++){
                $p = random_int(0,$len);
                $s .= $this->str{$p};
            }
        return $s;
    }

    /**
     * 生成验证码并存储
     * @param $identifier
     * @param int $size
     * @return string
     * @throws \Exception
     */
    public function generateAndStore($identifier,$size = 6){

        for($j = 0;$j < 3; $j++){
            $s = $this->generate($size);
            if($this->store($identifier,$s)){
                return $s;
            }
        }
        throw new \Exception('failed to generate vcode!');
    }

    /**
     * 存储
     * @param $identifier
     * @param $code
     * @return bool
     */
    public  function store($identifier,$code){

        $key = $this->getKey($identifier);
        Redis::multi()
        ->set($key,$code)
        ->expire($key,$this->expire)
        ->exec()
        ;
        return true;
    }

    /**
     * 验证
     * @param $identifier
     * @param $code
     * @return bool
     */
    public function check($identifier,$code){
        $key = $this->getKey($identifier);
        $c = Redis::get($key);
        return $c === $code;
    }

    /**
     * 删除验证码
     * @param $identifier
     * @return mixed
     */
    public function del($identifier){
        return Redis::del($this->getKey($identifier));
    }

    /**
     * 获取键名
     * @param $identifier
     * @return string
     */
    protected function getKey($identifier){
        return  $this->key.':'.$identifier;
    }

}
