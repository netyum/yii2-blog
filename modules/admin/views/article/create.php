<?php

use \Yii;
use \yii\helpers\Html;
use \yii\bootstrap\Tabs;
use \yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\ar\Category;
use app\helpers\StringHelper as Str;

$this->title = '添加新文章 :: 后台管理 :: ' . Yii::$app->id;

$this->registerJsFile("@web/assets/bootstrap/bootstrap-markdown/js/markdown.js", ['\yii\web\YiiAsset']);
$this->registerJsFile("@web/assets/bootstrap/bootstrap-markdown/js/to-markdown.js", ['\yii\web\YiiAsset']);
$this->registerJsFile("@web/assets/bootstrap/bootstrap-markdown/js/bootstrap-markdown.js", ['\yii\web\YiiAsset']);
$this->registerCssFile("@web/assets/bootstrap/bootstrap-markdown/css/bootstrap-markdown.min.css", ['\yii\web\YiiAsset']);
?>
<?php
if (Yii::$app->session->hasFlash('create_artcile')) :
    $message = Yii::$app->session->getFlash('create_artcile');
?>
<div class="alert alert-success alert-dismissable" style="margin-top:1em;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Html::encode($message);?>
</div>
<?php
endif;
?>
<h3>
    添加新文章
    <div class="pull-right">
        <?php echo Html::a('返回文章列表', ['index'], ['class'=>'btn btn-sm btn-default']);?>
    </div>
</h3>
<?php
$form = ActiveForm::begin([
    'enableClientValidation' => false,
]);

$categories = Category::getCategories();
$items = ArrayHelper::map($categories, 'id', 'name');

$tab1  = $form->field($model, 'category_id')->dropDownList($items);
$tab1 .= $form->field($model, 'title')->textInput();

$slug = Html::tag('span', rtrim(Yii::$app->request->getHostInfo(), '/') .'/', ['class'=>'input-group-addon']);
$slugTemplate = "{label}\n<div class=\"input-group\">{$slug}{input}</div>\n{hint}\n{error}";
$tab1 .= $form->field($model, 'slug', ['template'=>$slugTemplate])->textInput();
$tab1 .= $form->field($model, 'content')->textarea([
    "data-provide"=>"markdown",
    "rows"=>10,
]);
$tab2 = $form->field($model, 'meta_title')->textInput();
$tab2 .= $form->field($model, 'meta_description')->textInput();
$tab2 .= $form->field($model, 'meta_keywords')->textInput();

echo Tabs::widget([
    'items' => [
        [
            'label' => '主要内容',
            'options'=>['style'=>'padding:1em;'],
            'content' => $tab1,
            'active' => true
        ],
        [
            'label' => 'SEO',
            'content' => $tab2,
            'options'=>['style'=>'padding:1em;'],
        ]
    ]
]);
?>
<?php echo Html::a('清 空', ['create'], ['class' => 'btn btn-default']);?>

<?php echo Html::submitButton('提 交', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end();?>
