<?php

/*
return [
    'class' => '\yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_blog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
*/

return [
    'class' => '\yii\db\Connection',
    'dsn' => 'sqlite:'.dirname(__FILE__).'/../data/blog.sqlite',
    'charset' => 'utf8',
    'tablePrefix' => 'yii2_'

];
