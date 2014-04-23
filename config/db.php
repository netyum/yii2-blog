<?php
/*
return [
    'class' => '\yii\db\Connection',
    'dsn' => 'mysql:host=172.16.10.47;dbname=test',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
    'tablePrefix'=>'yii2_'
];
*/

return [
    'class' => '\yii\db\Connection',
    'dsn' => 'sqlite:'.dirname(__FILE__).'/../data/blog.sqlite',
    'charset' => 'utf8',
    'tablePrefix' => 'yii2_'

];
