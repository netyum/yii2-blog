<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = '密码重置 :: ' . Yii::$app->id;

$style =<<<EOF
    .form-register {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-register .form-register-heading,
    .form-register .checkbox {
        margin-bottom: 10px;
    }
    .form-register .checkbox {
        font-weight: normal;
    }
    .form-register .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
    }
    .form-register input{
        margin-top: 10px;
    }
    .form-register button{
        margin-top: 10px;
    }
    .form-register strong.error{
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
    'enableClientValidation' => false,
    'options' => ['class' => 'form-register'],
]); ?>
    <h2 class="form-register-heading">密码重置</h2>
<?php
echo $form->field($model, 'email', ['template' => "{input}"])->textInput([
    'placeholder' => '请输入您注册时所使用的邮箱',
    'required' => true,
    'autofocus' => true
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

<?php echo Html::submitButton('重 置', ['class' => 'btn btn-lg btn-danger btn-block']) ?>
<?php ActiveForm::end(); ?>
