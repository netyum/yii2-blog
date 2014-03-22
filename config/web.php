<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$mail = require(__DIR__. '/mail.php');
$rules = require(__DIR__. '/url_rules.php');

$config = [
    'id' => 'Yii2 Blog',
    'basePath' => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'language' => 'zh-CN',
    'modules' => [
        'admin' => 'app\modules\admin\Module'
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/sign-in']
        ],
        'errorHandler' => [
            'errorAction' => 'auth/error',
        ],
        'mail' => $mail,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['preload'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = 'yii\gii\Module';
}
else {
    $config['components']['urlManager'] = [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => $rules
    ];
}
return $config;
