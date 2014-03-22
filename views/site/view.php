<?php

use \yii\helpers\Html;
use \yii\widgets\DetailView;
use \yii\helpers\Markdown;
use \yii\widgets\ActiveForm;

use app\helpers\StringHelper as Str;
use app\models\ar\Comment;

$this->title = $article->title. ' :: ' . Yii::$app->id;


if (trim($article->meta_description) != '')
    $this->registerMetaTag(['name'=>'description', 'content'=>$article->meta_description]);

if (trim($article->meta_keywords) != '')
    $this->registerMetaTag(['name'=>'keywords', 'content'=>$article->meta_keywords]);

if (trim($article->meta_title) != '')
    $this->registerMetaTag(['name'=>'title', 'content'=>$article->meta_title]);
?>

<div class="col-xs-12 col-sm-9">
    <div class="row">
        <div class="col-6 col-sm-6 col-lg-12 panel">
            <h2><?php echo $article->title;?></h2>
            <hr />
            <p><?php echo Markdown::process($article->content, 'gfm');?></p>
            <a name="comments"></a>
            <p>
                <i class="glyphicon glyphicon-calendar"></i><span><?php echo $article->created_at;?>（<?php echo Str::friendlyDate($article->created_at);?>）</span>
            </p>
        </div><!--/span-->

        <div class="col-6 col-sm-6 col-lg-12 panel">
            <h4>评论 - <?php echo $article->comments_count;?></h4>
            <ul class="media-list">
<?php
$comments = $article->comments;
foreach($comments as $comment) :
?>
                <li class="media">
                    <a class="pull-left" href="#">
                        <?php
                        $img = $comment->user ? $comment->user->portraitSmall : '';
                        $email = $comment->user ? $comment->user->email : '';
                        ?>
                        <img class="media-object img-thumbnail" width="64" height="64" src="<?php echo $img;?>" alt="头像（小）">
                    </a>
                    <div class="media-body well well-sm">
                        <h5 class="media-heading"><?php echo $email;?>
                            <small class="pull-right">发表于：<?php echo Str::friendlyDate($comment->created_at);?></small>
                        </h5>
                        <?php echo Html::encode($comment->content);?>
                    </div>
                </li>
<?php
endforeach;
?>
            </ul>
<?php
if ( Yii::$app->session->hasFlash('comment_message') ) :
?>
            <div class="alert alert-success alert-dismissable" style="margin-top:1em;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::$app->session->getFlash('comment_message');?>
            </div>
<?php
endif;

if (!Yii::$app->user->isGuest) :
            $form = ActiveForm::begin();
            echo $form->field($model, 'article_id', ['template' => "{input}"])->hiddenInput(['value'=>$article->id]);
            echo $form->field($model, 'content', ['template' => "{input}\n{hint}\n{error}"])->textarea(['rows'=>3]);

            echo Html::submitButton('发表评论', ['class' => 'btn btn-success pull-right']);
            ActiveForm::end();
else :
?>

            <div class="form-horizontal">
                <div class="form-control" style="height:5em">
                    <?= Html::a('登录', ['auth/sign-in'], ['class' => 'btn btn-primary']);?>
                    <?= Html::a('注册', ['auth/sign-up'], ['class' => 'btn btn-success']);?>
                </div>
                <?= Html::button('发表评论', ['class' => 'btn btn-defaut pull-right', 'style' => 'margin:1em 0;']);?>
            </div>
<?php
endif;
?>
        </div><!--/span-->

    </div><!--/row-->
</div><!--/span-->
