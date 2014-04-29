<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/web.php'),
    require(__DIR__ . '/../_config.php'),
    [
        'components' => [
            'db' => [
                'class' => '\yii\db\Connection',
                'dsn' => 'sqlite:'.dirname(__FILE__).'/../../data/blog.unit.sqlite',
                'charset' => 'utf8',
                'tablePrefix' => 'yii2_'
            ],
        ],
    ]
);
