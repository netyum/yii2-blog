<?php

use \Yii;
use \yii\helpers\Html;
use \yii\bootstrap\Tabs;
use \yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\ar\Category;
use app\helpers\StringHelper as Str;

$this->title = '添加新文章分类 :: 后台管理 :: ' . Yii::$app->id;
?>
<?php
if (Yii::$app->session->hasFlash('create_category')) :
    $message = Yii::$app->session->getFlash('create_category');
    ?>
    <div class="alert alert-success alert-dismissable" style="margin-top:1em;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Html::encode($message);?>
    </div>
<?php
endif;
?>
<h3>
    添加新文章分类
    <div class="pull-right">
        <?php echo Html::a('返回文章分类列表', ['index'], ['class'=>'btn btn-sm btn-default']);?>
    </div>
</h3>
<?php
$form = ActiveForm::begin([
    'enableClientValidation' => false,
]);

$tab1 = $form->field($model, 'name')->textInput();
$tab1 .= $form->field($model, 'sort_order')->textInput();

echo Tabs::widget([
    'items' => [
        [
            'label' => '主要内容',
            'options'=>['style'=>'padding:1em;'],
            'content' => $tab1,
            'active' => true
        ]
    ]
]);
?>
<?php echo Html::a('清 空', ['create'], ['class' => 'btn btn-default']);?>

<?php echo Html::submitButton('提 交', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end();?>
