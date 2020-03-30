<?php

//示例
return [

    'driver' => 'aliyun',

    'aliyun' => [

        
        'key' => env('ALIYUN_KEY'),
        'secret' => env('ALIYUN_SECRET'),
        'regionId' => 'cn-hangzhou',

        'sendSms' => [
            'options' =>[

                'TemplateCode' => '',
                'SignName' => '',
            ]
        ]


    ]

];
