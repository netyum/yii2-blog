<?php

namespace app\modules\admin\controllers;

use \yii\web\Controller;
use \yii\filters\AccessControl;

class DefaultController extends Controller
{
    public $layout = "@admin/views/layouts/admin.php";

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

    public function actionIndex()
    {
        return $this->render('index');
    }
}
