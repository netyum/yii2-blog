<?php
use \Yii;
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\grid\GridView;
use \yii\bootstrap\Modal;

$this->title = '我评论过的文章 :: 用户中心 :: ' . Yii::$app->id;
?>

<h3>我评论过的文章</h3>
<?php
$error = $success = $class = "";
if (Yii::$app->session->hasFlash('my_comment_delete_success')) {
    $success = Yii::$app->session->getFlash('my_comment_delete_success');
}
else if (Yii::$app->session->hasFlash('my_comment_delete_error')) {
    $error = Yii::$app->session->getFlash('my_comment_delete_error');
}
if ($error != '' or $success != '') :
    $class = $error != '' ? 'alert-warning' :
                    $success != '' ? 'alert-success' : '';
    $message = $error != '' ? $error :
        $success != '' ? $success : '';
?>
<div class="alert <?php echo $class;?> alert-dismissable" style="margin-top:1em;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Html::encode($message);?>
</div>
<?php
endif;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['class'=>'table-responsive'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['header'=>'文章标题', 'format'=>'html', 'value'=>function($model, $index, $widget) {
            return yii\helpers\Html::a($model->article->title,
                                            ["site/view", "slug"=>$model->article->slug]);
        }],
        ['header'=>'评论内容', 'value' => 'content', 'enableSorting' => false],
        ['header'=>'创建时间', 'value' => 'created_at', 'enableSorting' => false],
        [
            'header'=>'操作',
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{my-comment}',
            'buttons' => [
                'my-comment' => function($url, $model) {
                    return "<a onclick=\"window['modal']('". $url ."')\" class=\"btn btn-xs btn-danger\" href=\"javascript:void(0)\">删除评论</a>";
                }
            ]
        ],
    ],
]);

$footer = Html::beginForm('', 'post', [
    'id' => 'real-delete',
]);

$footer .= Html::button('取消',[
    'class' => 'btn btn-sm btn-default',
    'data-dismiss' => 'modal',
    'type' => 'button'
]);

$footer .= Html::button('确认删除',[
    'class' => 'btn btn-sm btn-danger',
]);

$footer .= Html::endForm();

Modal::begin([
    'header' => '<h4 class="modal-title">系统提示</h4>',
    'id' => 'myModal',
    'footer' => $footer
]);

echo '确认删除此评论？';

Modal::end();

$js =<<<EOF
window['modal'] = function(href)
{
    jQuery('#real-delete').attr('action', href);
    jQuery('#myModal').modal();
}
EOF;

$this->registerJs($js);
