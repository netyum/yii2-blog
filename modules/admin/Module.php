<?php

namespace app\modules\admin;

use \Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
        Yii::setAlias('@admin', __DIR__);

        // custom initialization code goes here
    }

    public function beforeAction($action)
    {
        
        if (Yii$app->user->isGuest || !Yii::$app->user->identity->isAdmin) {
            return Yii::$app->response->redirect(['/site/index']);
        }
        return true;
    }
}
