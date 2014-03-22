<?php
return [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => '',
        'username' => '',
        'password' => '',
        'port' => '',
        'encryption' => 'tls',
    ],
    'messageConfig' => [
        'charset' => 'UTF-8',
        // ['email'=>'name']
        //'from' => ['' => '']
    ]
];
