<?php

namespace app\models\form;

use \Yii;
use \yii\base\Model;
use app\models\User;
use app\models\ar\PasswordReminder;
use app\helpers\StringHelper as Str;
use \Carbon\Carbon;

/**
 * ForgotPassForm is the model behind the login form.
 */
class ForgotPassForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass'=>'app\models\User']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
        ];
    }

    /**
     * 忘了密码
     */
    public function forgot()
    {
        if ($this->validate()) {
            $passwordReminder = new PasswordReminder;
            $passwordReminder->email = $this->email;
            $passwordReminder->token = Str::random(40);
            $passwordReminder->created_at = new Carbon();
            $passwordReminder->save(false);

            Yii::$app->mail->compose('forgotpassword', ['token'=>$passwordReminder->token])
                ->setTo($this->email)
                ->setSubject(Yii::$app->id .' 重置密码邮件')
                ->send();
            return true;
        }
        return false;
    }
}
