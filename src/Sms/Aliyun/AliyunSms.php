<?php


namespace Huyibin\Sms\Aliyun;


use AlibabaCloud\Client\AlibabaCloud;
use Huyibin\Sms\Events\Events\VerificationCodeSend;
use Huyibin\Sms\SmsBase;
use Huyibin\Sms\SmsInterface;

class AliyunSms extends SmsBase
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
