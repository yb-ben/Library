<?php


namespace Huyibin\Sms\Aliyun;


use AlibabaCloud\Client\AlibabaCloud;
use Huyibin\Sms\SmsInterface;

class AliyunSms implements SmsInterface
{

    protected $accessKeyId;
    protected $accessSecret;
    protected $regionId;



    public function __construct()
    {

        $this->accessKeyId = config('sms.aliyun.key');
        $this->accessSecret = config('sms.aliyun.secret');
        $this->regionId = config('sms.aliyun.regionId','cn-hangzhou');

        $this->init();

    }


    protected function init(){
        AlibabaCloud::accessKeyClient($this->accessKeyId,$this->accessSecret)
            ->regionId($this->regionId)
            ->asDefaultClient();
    }


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

    /**
     * 短信发送
     *
     * @param string $phoneNumber
     * @param array $param
     * @return Array
     */
    public function sendSms(string $phoneNumber,array $param):Array{

        $query = [
            'RegionId'=> $this->regionId,
            'PhoneNumbers' => $phoneNumber,
            'SignName' => config('sms.aliyun.sendSms.options.SignName'),
            'TemplateCode' => config('sms.aliyun.sendSms.options.TemplateCode'),
            'TemplateParam' => json_encode($param)
        ];

        return AlibabaCloud::rpc()
        ->product('Dysmsapi')
        ->version('2017-05-25')
        ->action('SendSms')
        ->method('POST')
        ->host('dysmsapi.aliyuncs.com')
        ->options([
            'query' =>$query
        ])
        ->request()->toArray();
    }




}
