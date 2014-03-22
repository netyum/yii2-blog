<?php
use \Yii;
use \yii\helpers\Url;

?>
<p>请点击以下链接完成密码重置：
    <?php
        $url = Url::to(['/auth/reset-password', 'token' => $token], true);
    ?>
    <br /><a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a>
</p>