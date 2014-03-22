<?php

use \Yii;
use \yii\helpers\Html;
use \yii\bootstrap\Tabs;
use \yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\helpers\StringHelper as Str;

$this->title = '添加新用户 :: 后台管理 :: ' . Yii::$app->id;
$this->registerJsFile("@web/bootstrap/bootstrap-switch/js/bootstrap-switch.min.js", ['\yii\web\YiiAsset']);
$this->registerCssFile("@web/bootstrap/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css", ['\yii\web\YiiAsset']);

$js=<<<EOF
    jQuery('input[type="checkbox"],[type="radio"]').bootstrapSwitch();
EOF;

$this->registerJs($js);
?>
<?php
if (Yii::$app->session->hasFlash('create_user')) :
    $message = Yii::$app->session->getFlash('create_user');
    ?>
    <div class="alert alert-success alert-dismissable" style="margin-top:1em;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Html::encode($message);?>
    </div>
<?php
endif;
?>
    <h3>
        添加新用户
        <div class="pull-right">
            <?php echo Html::a('返回用户列表', ['index'], ['class'=>'btn btn-sm btn-default']);?>
        </div>
    </h3>
<?php
$form = ActiveForm::begin([
    'enableClientValidation' => false,
]);

$tab1  = $form->field($model, 'email')->textInput();
$tab1 .= $form->field($model, 'password')->passwordInput();
$tab1 .= $form->field($model, 'password_repeat')->passwordInput();

$tab2 = $form->field($model, 'is_admin', ['template'=>"{label}\n<div>{input}</div>\n{hint}\n{error}"])->checkbox([
    'value'=>1,
    'data-on'=>'danger',
    'data-off'=>'default',
    'data-text-label'=>"　　　　",
    'data-on-label'=>"管理员",
    'data-off-label'=>"普通用户"
], false);

echo Tabs::widget([
    'items' => [
        [
            'label' => '主要内容',
            'options'=>['style'=>'padding:1em;'],
            'content' => $tab1,
            'active' => true
        ],
        [
            'label' => '权限相关',
            'content' => $tab2,
            'options'=>['style'=>'padding:1em;'],
        ]
    ]
]);
?>
<?php echo Html::a('清 空', ['create'], ['class' => 'btn btn-default']);?>

<?php echo Html::submitButton('提 交', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end();?>
