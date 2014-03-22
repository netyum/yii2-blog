<?php
use app\widgets\Nav;
use \yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => '后台管理',
    'brandUrl' => ['/admin/default/index'],
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'style' => 'background-color:#fff;border-color:#fff;'
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => '后台首页', 'url' => ['/admin/default/index']],
        ['label' => '用户管理', 'url' => ['/admin/user/index']],
        ['label' => '分类管理', 'url' => ['/admin/category/index']],
        ['label' => '文章管理', 'url' => ['/admin/article/index']],
    ]
]);



$items = [
    [
        'label' => '[ ' . Yii::$app->user->identity->email . '] ',
        'items' => [
            ['label' => '回到博客', 'url' => ['/site/index']],
            ['label' => '用户中心', 'url' => ['/account/index']],
            '<li class="divider"></li>',
            ['label' => '退出', 'url' => ['/auth/logout'], 'linkOptions' => ['data-method' => 'post']],
        ]
    ]
];

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();
