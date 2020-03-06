<?php

namespace Huyibin;

use Firebase\JWT\JWT as FirebaseJWT;

class JWT
{

    protected $key = '';
    protected $actExpireTime = 7200;
    protected $rftExpireTime = 86400 * 7;
    protected $tokenRaw = [
        'iss' => '', //签发者
        'aud' => '', //接收方
        'scope' => '',
        'nbf' => '',
        'exp' => '',
        'data' => '',
    ];

    //签发
    public function authorizations($data)
    {
        $time = time();
        $accessToken = $this->tokenRaw;
        $accessToken['scope'] = 'access';
        $accessToken['exp'] = $time + $this->actExpireTime;
        $accessToken['nbf'] = $time;
        $accessToken['data'] = $data;

        $refreshToken = $this->tokenRaw;
        $refreshToken['scope'] = 'refresh';
        $refreshToken['exp'] = $time + $this->rftExpireTime;
        $refreshToken['nbf'] = $time;
        $refreshToken['data'] = $data;

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
        $arr = (array) $decoded;
        return $arr;
    }

}
