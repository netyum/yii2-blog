<?php

namespace app\modules\admin\controllers;

use \Yii;
use app\models\User;
use app\models\search\UserSearch;
use \yii\web\Controller;
use \yii\web\NotFoundHttpException;
use \yii\filters\VerbFilter;
use \yii\filters\AccessControl;


use app\helpers\StringHelper as Str;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public $layout = "@admin/views/layouts/admin.php";

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->salt = Str::random(10);
                $model->password = $model->generatePassword($model->password);


                if ($model->save(false)) {
                    Yii::$app->session->setFlash('create_user', '用户添加成功：您可以继续添加新用户，或返回用户列表。');
                    return $this->redirect(['create']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($id !== null && ($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求页面不存在');
        }
    }
}
