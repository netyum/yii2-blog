<?php
use \yii\helpers\Html;
use \yii\helpers\Markdown;
use \yii\helpers\Url;
use \yii\widgets\LinkPager;

use app\helpers\StringHelper as Str;


$this->title = Yii::$app->id;
?>

    <div class="col-xs-12 col-sm-9">
        <div class="row">
<?php
foreach($articles as $article) :
?>
            <div class="col-6 col-sm-6 col-lg-12 panel">
                <h2>

                    <a href="<?php echo Url::to(['site/view', 'slug'=>$article->slug]);?>"><?php echo Html::encode($article->title);?></a>
                    <a target="_blank" class="pull-left"
                       href="<?php echo Url::to(['site/view', 'slug'=>$article->slug]);?>">
                        <i class="glyphicon glyphicon-share" style="font-size:0.5em;margin-right:1em;"></i>
                    </a>
                </h2>
                <p>
<?php
$html = Markdown::process($article->content, 'gfm');
echo Str::closeTags(Str::limit($html, 200));
?>
                </p>
                <p>
                    <i class="glyphicon glyphicon-calendar"></i><span><?php echo $article->created_at;?>（<?php echo Str::friendlyDate($article->created_at);?>）</span>
                    <a target="_blank" href="<?php echo Url::to(['site/view', 'slug'=>$article->slug]);?>#comments">
                        <i class="glyphicon glyphicon-share" style="font-size:0.5em;"></i>
                    </a>
                    <a href="<?php echo Url::to(['site/view', 'slug'=>$article->slug]);?>#comments"
                       class="btn btn-default btn-xs" style="margin-top:-2px;"
                       role="button">评论（<?php echo $article->comments_count;?>）</a>
                </p>
            </div><!--/span-->
<?php
endforeach;
?>

            <div>
<?php
if (count($articles) > 0)
    echo LinkPager::widget(['pagination'=>$pages]);
?>
            </div>

        </div><!--/row-->
    </div><!--/span-->
