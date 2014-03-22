<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = '修改密码 :: 用户中心 :: ' . Yii::$app->id;

$style =<<<EOF
    .form
    {
        width: 330px;
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
$this->registerJs($js);
?>

<?php $form = ActiveForm::begin([
    'id' => 'sign-up-form',
    'enableClientValidation' => false,
    'options' => ['class' => 'form'],
]); ?>
<h2 class="form-register-heading">修改您的密码</h2>
<?php
echo $form->field($model, 'password_old', ['template' => "{input}"])->passwordInput([
    'placeholder' => '原始密码',
    'required' => true
]);

$hint = Html::button('?',[
    'data-content' => '请使用字母、数字、下划线、中划线。长度在6-16位之间。',
    'class' => 'btn btn-default',
    'data-toggle' => 'popover',
    'data-original-title' => '',
    'title' => '',
    'type' => 'button'
]);

$hint = Html::tag('span', $hint, ['class' => 'input-group-btn']);
echo $form->field($model, 'password', [
    'template' => "{input}\n{$hint}",
    'options' => ['class' => 'input-group']
])->passwordInput([
    'placeholder' => '新密码',
    'required' => true
]);

echo $form->field($model, 'password_repeat', ['template' => "{input}"])->passwordInput([
    'placeholder' => '确认密码',
    'required' => true
]);

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
if (Yii::$app->session->hasFlash('changepassword')) :
    $message = Yii::$app->session->getFlash('changepassword');
    ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo Html::encode($message);?></strong>
    </div>
<?php
endif;
?>

<?php echo Html::submitButton('确认修改', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
<?php ActiveForm::end(); ?>
