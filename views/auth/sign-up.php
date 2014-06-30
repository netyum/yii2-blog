<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = '注册 :: ' . Yii::$app->id;

$style =<<<EOF
    .form-signup {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signup .form-signup-heading,
    .form-signup .checkbox {
        margin-bottom: 10px;
    }
    .form-signup .checkbox {
        font-weight: normal;
    }
    .form-signup .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
    }
    .form-signup input{
        margin-top: 10px;
    }
    .form-signup button{
        margin-top: 10px;
    }
    .form-signup strong.error{
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
    'options' => ['class' => 'form-signup'],
]); ?>
<h2 class="form-signup-heading">用户注册</h2>
<?php
echo $form->field($model, 'email', ['template' => "{input}"])->textInput([
    'placeholder' => '邮箱',
    'required' => true,
    'autofocus' => true
]);

$hint = Html::button('?', [
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
    'placeholder' => '密码',
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
?>

<?php echo Html::submitButton('注 册', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
<?php
ActiveForm::end();
