<?php
use app\widgets\Nav;
use \yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->id,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'style' => 'background-color:#fff;border-color:#fff;'
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => '首页', 'url' => ['/site/index']],
    ]
]);

if (Yii::$app->user->isGuest) {
    $items = [
        ['label' => '登录', 'url' => ['/auth/sign-in']],
        ['label' => '注册', 'url' => ['/auth/sign-up']]
    ];
} elseif (!Yii::$app->user->identity->isAdmin) {
    $items = [
        [
            'label' => '[ ' . Yii::$app->user->identity->email . '] ',
            'items' => [
                ['label' => '用户中心', 'url' => ['/account']],
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
                ['label' => '用户中心', 'url' => ['/account/index']],
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
