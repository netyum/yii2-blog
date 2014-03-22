<?php

namespace app\models\form;

use \Yii;
use \yii\base\Model;
use app\models\User;
use app\models\ar\Activation;
use app\helpers\StringHelper as Str;
use \Carbon\Carbon;

/**
 * SignUpForm is the model behind the login form.
 */
class SignUpForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute'=>'password_repeat'],
            ['password', 'string', 'max'=>16, 'min'=>6],
            ['password', 'match', 'pattern'=> '/^[0-9A-Za-z_-]+$/', 'message'=>'密码请使用字母、数字、下划线、中划线。'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=>'app\models\User', 'message'=>'邮箱"{value}"已经被注册，请更换', 'on'=>'signup'],
            ['email', 'exist', 'targetClass'=>'app\models\User', 'on'=>'reset']
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
            'password_repeat' => '确认密码'
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User;
            $user->email = $this->email;
            $user->salt = Str::random(10);
            $user->password = $user->generatePassword($this->password);
            if ($user->save(false)) {
                // 添加成功
                // 生成激活码
                $activation = new Activation;
                $activation->email = $user->email;
                $activation->token = Str::random(40);
                $activation->created_at = new Carbon();
                $activation->save(false);

                Yii::$app->mail->compose('activation', ['activationCode'=>$activation->token])
                    ->setTo($user->email)
                    ->setSubject(Yii::$app->id .' 账号激活邮件')
                    ->send();
                return true;
            }
        }
        $this->addError('email', '注册失败');
        return false;
    }

    public function resetPassword() {
        if ($this->validate()) {
            $user = User::findByEmail($this->email, true);
            if (is_null($user)) {
                $this->addError('email', '无效的邮箱');
                return false;
            }
            $user->salt = Str::random(10);
            $user->password = $user->generatePassword($this->password);
            return $user->save();
        }
        $this->addError('password', '重置密码失败');
        return false;
    }

}
