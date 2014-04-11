<?php

namespace app\controllers;

use \Yii;
use app\models\form\ChangePassForm;
use app\models\form\PortraitForm;
use app\models\search\CommentSearch;
use app\models\ar\Comment;
use \yii\helpers\FileHelper;
use \yii\web\UploadedFile;
use \yii\filters\AccessControl;

class AccountController extends \yii\web\Controller
{

    public $layout = '@app/views/layouts/account';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * 修改密码
     * @return string|\yii\web\Response
     */
    public function actionChangePassword()
    {
        $model = new ChangePassForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('changepassword', "密码修改成功");
                return $this->redirect(['account/change-password']);
            }
            else {
                $model->addError('password_ord', "密码修改失败");
            }
        }
        return $this->render('change-password',[
           'model' => $model
        ]);
    }

    /**
     * 我的评论
     * @param string $id
     * @return string|\yii\web\Response
     */
    public function actionMyComment($id="")
    {
        if (Yii::$app->request->isPost && $id!='') {
            $model = Comment::findOne($id);

            if ($model->user_id == Yii::$app->user->identity->id) {
                Yii::$app->session->setFlash('my_comment_delete_success', '评论删除成功');
                $model->delete();
            }
            else {
                Yii::$app->session->setFlash('my_comment_delete_error', '评论删除失败');
            }
            return $this->redirect(['account/my-comment']);
        }

        $searchModel = new CommentSearch;
        $dataProvider = $searchModel->mySearch(Yii::$app->user->identity->id);

        return $this->render('my-comment', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 修改头像
     * @return string|\yii\web\Response
     */
    public function actionChangePortrait()
    {
        $model = new PortraitForm;

        if (Yii::$app->request->isPost) {
            $model->portrait = UploadedFile::getInstance($model, 'portrait');
            if ($model->validate() && $model->changePortrait()) {
                return $this->redirect(['account/change-portrait']);
            }
        }
        return $this->render('change-portrait', [
            'model' => $model
        ]);
    }

}
