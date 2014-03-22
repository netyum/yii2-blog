<?php

namespace app\models\form;

use \Yii;
use \yii\base\Model;
use app\models\User;
use app\models\ar\Activation;

/**
 * SignInForm is the model behind the login form.
 */
class SignInForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'max'=>16, 'min'=>6],
            ['password', 'match', 'pattern'=> '/^[0-9A-Za-z_-]+$/', 'message'=>'密码请使用字母、数字、下划线、中划线。'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['email', 'validateActivation'],
            ['password', 'validatePassword']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'password' => '密码',
            'rememberMe' => '记住我'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', '无效的邮箱或密码');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $isLogin = Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            if ($isLogin) {
                User::findByEmail($model->email, true)->updateAttributes(['signin_at'=>new Carbon]);
                return true;
            }
        }
        return false;
    }

    public function validateActivation()
    {
        if (!$this->hasErrors()) {
            $activation = Activation::find()->where(['email'=>$this->email])->one();
            if ($activation) {
                $this->addError('email', '邮箱未激活');
            }
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }

}
