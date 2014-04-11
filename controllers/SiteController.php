<?php

namespace app\controllers;

use \Yii;
use \yii\filters\AccessControl;
use \yii\web\Controller;
use \yii\web\HttpException;
use \yii\data\Pagination;
use \yii\web\VerbFilter;
use app\models\ar\Comment;
use app\models\ar\Article;

use \Carbon\Carbon;



class SiteController extends Controller
{

    public $layout = '@app/views/layouts/site';

    public function actionIndex($category_id="")
    {
        $query = Article::find();
        if (intval($category_id) != 0) {
            $query->where('category_id=:category_id', array(":category_id"=>$category_id));
        }
        $query->orderBy('created_at DESC, updated_at DESC');
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 10
        ]);

        $articles = $query->offset($pages->offset)
                          ->limit($pages->limit)
                          ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pages' => $pages
        ]);
    }

    public function actionView($slug) {

        $model = new Comment;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = new Carbon();
            $model->updated_at = new Carbon();
            $model->user_id = Yii::$app->user->identity->id;
            if ( $model->save() ) {
                $model->article->updateAllCounters(['comments_count'=>1]);
                return $this->redirect(['view', 'slug' => $slug]);
            }
        }

        $article = Article::findOne(['slug'=>$slug]);
        if (is_null($article)) {
            throw new NotFoundHttpException('请求页面不存在');
        }

        return $this->render('view', [
           'article' => $article,
           'model' => $model
        ]);
    }

}
