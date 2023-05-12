<?php

//短信发送配置
return [
    // HTTP请求说完超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        //网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可发送的网关
        'gateways' => [
            'qcloud',  //腾讯云
        ],

    ],

    //可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'qcloud' => [
            'sdk_app_id' => env('QCLOUD_SDK_APP_ID'),
            'sign_name' => env('QCUOUD_SIGN_NAME'),
            'template_id' => env('QCLOUD_TEMPLATE_ID'),
            'secret_id' => env('SECRET_ID'),
            'secret_key' => env('SECRET_KEY'),
        ],
    ],
];
