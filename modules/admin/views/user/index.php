<?php

use \yii\helpers\Html;
use \yii\grid\GridView;
use \yii\bootstrap\Modal;

$this->title = '用户管理 :: 后台管理 :: ' . Yii::$app->id;
?>

<h3>
    用户管理
    <div class="pull-right">
        <?= Html::a('添加新用户', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
</h3>
<?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => ['class' => 'table-responsive'],
    'columns' => [
        [
            'attribute'=>'is_admin',
            'value' => function ($model, $index, $widget) {
                return $model->is_admin==1 ? '管理员' : '普通用户';
            }
        ],
        'email:email',
        [
            'attribute' => 'created_at',
            'value' => function ($model, $index, $widget) {
                return $model->created_at.' ('. app\helpers\StringHelper::friendlyDate($model->created_at).')';
            }
        ],
        [
            'attribute' => 'signin_at',
            'value' => function ($model, $index, $widget) {
                return $model->signin_at ?
                            $model->signin_at.' ('. app\helpers\StringHelper::friendlyDate($model->created_at).')' :
                            '（新账号尚未登录）';

            }
        ],
        [
            'header'=>'操作',
            'class' => '\yii\grid\ActionColumn',
            'template'=>'{delete}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    if ($model->is_admin == 0) {
                        return "<a onclick=\"window['modal']('". $url ."')\" class=\"btn btn-xs btn-danger\" href=\"javascript:void(0)\">删除</a>";
                    }
                }
            ]
        ],
    ],
]);

$footer = Html::beginForm('', 'post', [
'id' => 'real-delete',
]);

$footer .= Html::button('取消', [
'class' => 'btn btn-sm btn-default',
'data-dismiss' => 'modal',
'type' => 'button'
]);

$footer .= Html::button('确认删除', [
'class' => 'btn btn-sm btn-danger',
]);

$footer .= Html::endForm();

Modal::begin([
'header' => '<h4 class="modal-title">系统提示</h4>',
'id' => 'myModal',
'footer' => $footer
]);

echo '确认删除此用户？';

Modal::end();

$js =<<<EOF
    window['modal'] = function(href)
{
jQuery('#real-delete').attr('action', href);
jQuery('#myModal').modal();
}
EOF;

$this->registerJs($js);
