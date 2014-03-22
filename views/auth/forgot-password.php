<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = '忘记密码 :: ' . Yii::$app->id;

$style =<<<EOF
    .center
    {
        text-align: center;
    }
    .form-center, .alert-dismissable
    {
        float: none;
        margin: 0 auto;
        margin-top: 2em;
    }
    .input-group
    {
        margin-top: 2em;
    }
EOF;

$this->registerCss($style);
?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'options' => ['class' => 'col-lg-6 form-center'],
]); ?>
    <h2 class="center">发送密码重置邮件</h2>
<?php

$hint = Html::button('发 送',[
    'class' => 'btn btn-lg btn-primary',
    'style' => 'width:9em;',
    'type' => 'submit'
]);

$hint = Html::tag('span', $hint, ['class' => 'input-group-btn']);
echo $form->field($model, 'email', [
    'template' => "{input}\n{$hint}",
    'options' => ['class' => 'input-group']
])->textInput([
        'class' => 'form-control input-lg',
        'placeholder' => '请填写您注册时所使用的邮箱',
        'required' => true
    ]);
?>

<?php
if ($model->getErrors()) :
$errors = $model->getErrors();
$error = array_shift($errors);
?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong><?php echo Html::encode($error[0]);?></strong>
</div>
<?php
endif;
if (Yii::$app->session->hasFlash('forgotpassword')) :
    $message = Yii::$app->session->getFlash('forgotpassword');
?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong><?php echo Html::encode($message);?></strong>
</div>
<?php
endif;
?>
<?php ActiveForm::end(); ?>
