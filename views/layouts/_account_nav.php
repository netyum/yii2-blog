<?php
use app\widgets\Nav;
use \yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => '用户中心',
    'brandUrl' => ['/account/index'],
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'style' => 'background-color:#fff;border-color:#fff;'
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => '修改密码', 'url' => ['/account/change-password']],
        ['label' => '更改头像', 'url' => ['/account/change-portrait']],
        ['label' => '我的评论', 'url' => ['/account/my-comment']],
    ]
]);

if (!Yii::$app->user->identity->isAdmin) {
    $items = [
        [
            'label' => '[ ' . Yii::$app->user->identity->email . '] ',
            'items' => [
                ['label' => '回到博客', 'url' => ['/site/index']],
                '<li class="divider"></li>',
                ['label' => '退出', 'url' => ['/auth/logout'], 'linkOptions' => ['data-method' => 'post']],
            ]
        ]
    ];
} elseif (Yii::$app->user->identity->isAdmin) {
    $items = [
        [
            'label' => '[ ' . Yii::$app->user->identity->email . '] ',
            'items' => [
                ['label' => '进入后台', 'url' => ['/admin/default/index']],
                ['label' => '回到博客', 'url' => ['/site/index']],
                '<li class="divider"></li>',
                ['label' => '退出', 'url' => ['/auth/logout'], 'linkOptions' => ['data-method' => 'post']],
            ]
        ]
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();
