<?php

namespace Huyibin;

use Firebase\JWT\JWT as FirebaseJWT;

class JWT
{

    protected $key;
    protected $actExpireTime;
    protected $rftExpireTime;
    protected $tokenRaw = [
        'iss' => '', //签发者
        'aud' => '', //接收方
        'scope' => '',
        'nbf' => '',
        'iat' => '',//jwt签发时间
        'exp' => '',
        'data' => '',
        'sub' =>'',//用户id
    ];

    protected $app;

    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {

        $key = env('JWT_KEY');
        if(!$key)
            throw new \Exception('未配置 JWT_KEY');

        $this->key = $key;
        $this->tokenRaw['aud'] = $this->tokenRaw['iss'] = env('APP_URL');
        $this->actExpireTime = env('JWT_EXPIRE',7200);
        $this->rftExpireTime = env('JWT_REFRESH_EXPIRE',86400*7);


    }


    //签发
    public function authorizations($data)
    {
        $time = time();
        $accessToken = $this->tokenRaw;
        $accessToken['scope'] = 'access';
        $accessToken['exp'] = $time + $this->actExpireTime;
        $accessToken['nbf'] = $time;
        $accessToken['data'] = $data;
        $accessToken['iat'] = $time;
        $accessToken['sub'] = $data['id'];

        $refreshToken = $this->tokenRaw;
        $refreshToken['scope'] = 'refresh';
        $refreshToken['exp'] = $time + $this->rftExpireTime;
        $refreshToken['nbf'] = $time;
        $refreshToken['iat'] = $time;
        $refreshToken['data'] = $data;
        $refreshToken['sub'] = $data['id'];


        $jsonData = [
            'access_token' => FirebaseJWT::encode($accessToken, $this->key),
            'refresh_token' => FirebaseJWT::encode($refreshToken, $this->key),
            'create_time' => $time,
            'token_type' => 'bearer', //令牌类型
        ];
        return json_encode($jsonData);
    }

    //验证
    public function verification($jwt)
    {
        FirebaseJWT::$leeway = 60; //当前时间减去60，把时间留点余地
        $decoded = FirebaseJWT::decode($jwt, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
        return (array) $decoded;
    }

}
