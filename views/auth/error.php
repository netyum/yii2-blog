<?php

use \yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Web服务器处理您的请求时发生上述错误。
    </p>
    <p>
        如果你认为这是一个服务器错误， 请联系我们，谢谢你.
    </p>

</div>
