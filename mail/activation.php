<?php
use \Yii;
use \yii\helpers\Url;

?>
<p>感谢您注册 <?php echo Yii::$app->id;?>，请点击以下链接激活您的账号：
    <br />
    <?php
        $url = Url::to(['/auth/activate', 'activationCode' => $activationCode], true);
    ?>
    <a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a>
</p>
