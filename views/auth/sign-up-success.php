<?php
use \yii\helpers\Html;

$this->title = '注册成功 :: ' . Yii::$app->id;

$style =<<<EOF
    .center
    {
        text-align: center;
    }
EOF;
$this->registerCss($style);
?>
<h2 class="center">请激活您的账号</h2>
<p class="center">激活邮件已发送，请登录您的邮箱（<?php echo Html::encode($email);?>）激活账号。</p>
