<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = '登录 :: ' . Yii::$app->id;

$style =<<<EOF
    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: 10px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
EOF;

$this->registerCss($style);
?>

<?php $form = ActiveForm::begin([
    'id' => 'sign-in-form',
    'enableClientValidation' => false,
    'options' => ['class' => 'form-signin'],
]); ?>
<h2 class="form-signin-heading">用户登录</h2>
<?php
echo $form->field($model, 'email', ['template' => "{input}"])->textInput([
    'placeholder' => '邮箱',
    'required' => true,
    'autofocus' => true
]);

echo $form->field($model, 'password', ['template' => "{input}"])->passwordInput([
    'placeholder' => '密码',
    'required' => true
]);

$forgotPasswordHtml = Html::a('忘记密码 &gt;&gt;&gt;', ['/auth/forgot-password']);
echo $form->field($model, 'rememberMe', [
    'template' => "<div class=\"col-lg-offset-1 col-lg-5\" style=\"height:50px;\">{input}</div>\n<div class=\"col-lg-5\" style=\"height:50px;padding-top:10px;\">{$forgotPasswordHtml}</div>",
])->checkbox();


if ($model->getErrors()) :
    $errors = $model->getErrors();
    $error = array_shift($errors);
?>
<div class="alert alert-warning alert-dismissable" style="margin-top:70px;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong><?php echo Html::encode($error[0]);?></strong>
</div>
<?php
endif;
?>

<?php echo Html::submitButton('登 录', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
<?php ActiveForm::end(); ?>
