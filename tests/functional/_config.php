<?php

// set correct script paths
$_SERVER['SCRIPT_FILENAME'] = TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = TEST_ENTRY_URL;

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/web.php'),
    require(__DIR__ . '/../_config.php'),
    [
        'components' => [
            'db' => [
                'class' => '\yii\db\Connection',
                'dsn' => 'sqlite:'.dirname(__FILE__).'/../../data/blog.sqlite',
                'charset' => 'utf8',
                'tablePrefix' => 'yii2_'
            ],
        ],
    ]
);
