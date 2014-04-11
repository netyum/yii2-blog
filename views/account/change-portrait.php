<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

use app\models\User;
$this->title = '修改头像 :: 用户中心 :: ' . Yii::$app->id;

$style =<<<EOF
    .form
    {
        width: 530px;
        margin: 0 auto;
        padding-bottom: 2em;
    }
    .form input, .form button
    {
        margin-top: 10px;
    }
    .form strong.error{
        color: #b94a48;
    }
EOF;

$js =<<<EOF
    jQuery('[data-toggle]').popover({container:'body'})
EOF;

$this->registerCss($style);

$form = ActiveForm::begin([
    'id' => 'sign-up-form',
    'enableClientValidation' => false,
    'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
]); ?>
    <h2 class="form-register-heading">更改您的头像</h2>
<?php
$user = User::findOne(Yii::$app->user->identity->id);
?>
<img class="img-thumbnail" width="220" height="220" src="<?php echo $user->portraitLarge;?>" alt="头像（大）">
<img class="img-thumbnail" width="128" height="128" src="<?php echo $user->portraitLarge;?>" alt="头像（中）">
<img class="img-thumbnail" width="64" height="64" src="<?php echo $user->portraitLarge;?>" alt="头像（小）">
<?php
echo $form->field($model, 'portrait', ['template' => "{input}\n{error}"])->fileInput();
echo Html::submitButton('上传头像', ['class' => 'btn btn-lg btn-primary btn-block']);
ActiveForm::end();
?>
