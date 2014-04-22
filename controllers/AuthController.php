<?php

namespace app\controllers;

use \Yii;
use \yii\web\HttpException;
use \yii\filters\AccessControl;
use \yii\filters\VerbFilter;
use app\models\ar\PasswordReminder;
use app\models\form\SignInForm;
use app\models\form\SignUpForm;
use app\models\form\ForgotPassForm;
use app\models\User;
use app\models\ar\Activation;

use \Carbon\Carbon;


class AuthController extends \yii\web\Controller
{

    public $layout = '@app/views/layouts/auth';

    public function actions()
    {
        return [
            'error' => [
                'class' => '\yii\web\ErrorAction',
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignInForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('sign-in', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 注册
     * @return string|\yii\web\Response
     */
    public function actionSignUp()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new SignUpForm;
        $model->scenario = 'signup';
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['auth/sign-up-success', 'email' => base64_encode($model->email)]);
        }

        return $this->render('sign-up', [
            'model' => $model
        ]);
    }

    /**
     * 注册成功，提示激活
     * @param $email
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionSignUpSuccess($email)
    {
        $email = base64_decode($email);
        $activation = Activation::findOne(['email'=>$email]);
        if (is_null($activation)) {
            throw new NotFoundHttpException('请求页面不存在');
        }

        return $this->render('sign-up-success', [
            'email' => $email
        ]);
    }

    /**
     * 激活
     * @param $activationCode
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionActivate($activationCode)
    {
        // 数据库验证令牌
        $activation = Activation::findOne(['token'=>$activationCode]);
        if (is_null($activation)) {
            throw new NotFoundHttpException('请求页面不存在');
        }
        // 激活对应用户
        $user = User::findByEmail($activation->email, true);
        $user->activated_at = new Carbon();
        $user->save();

        $activation->delete();
        // 删除令牌
        return $this->render('activation-success');
    }

    /**
     * 忘记密码
     * @return string
     */
    public function actionForgotPassword()
    {
        $model = new ForgotPassForm;

        if ($model->load(Yii::$app->request->post()) && $model->forgot()) {
            Yii::$app->session->setFlash('forgotpassword', '密码重置邮件已发送！');
            return $this->redirect(['/auth/forgot-password']);
        }

        return $this->render('forgot-password', [
            'model' => $model
        ]);
    }

    /**
     * 重置密码
     * @param $token
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionResetPassword($token)
    {
        $passwordReminder = PasswordReminder::findOne(['token'=>$token]);
        if (is_null($passwordReminder)) {
            throw new NotFoundHttpException('请求页面不存在');
        }
        $model = new SignUpForm;
        $model->scenario = 'reset';
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            //清掉$passwordReminder
            $passwordReminder->delete();
            unset($passwordReminder);
            return $this->goHome();
        }
        return $this->render('reset-password',[
            'model' => $model
        ]);
    }

    /**
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
