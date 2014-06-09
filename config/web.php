<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$mail = require(__DIR__. '/mail.php');
$rules = require(__DIR__. '/url_rules.php');

$config = [
    'id' => 'Yii2 Blog',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'language' => 'zh-CN',
    'modules' => [
        'admin' => 'app\modules\admin\Module',
        'markdown' => [
            // the module class
            'class' => 'kartik\markdown\Module',

            // the controller action route used for markdown editor preview
            'previewAction' => '/markdown/parse/preview',

            // the controller action route used for downloading the markdown exported file
            'downloadAction' => '/markdown/parse/download',

            // the list of custom conversion patterns for post processing
            'customConversion' => [
                '<table>' => '<table class="table table-bordered table-striped">'
            ],

            // whether to use PHP SmartyPantsTypographer to process Markdown output
            'smartyPants' => true,

            // array the the internalization configuration for this module
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@markdown/messages',
                'forceTranslation' => true
            ]
        ]
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
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug']['class'] = 'yii\debug\Module';
    $config['modules']['debug']['allowedIPs'] = ['*'];
    $config['bootstrap'][] = 'gii';
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
