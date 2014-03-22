<?php

namespace app\models\form;

use \Yii;
use \yii\base\Model;

use app\models\User;
use app\helpers\StringHelper as Str;
use \Carbon\Carbon;

/**
 * ChangePassForm is the model behind the login form.
 */
class ChangePassForm extends Model
{
    public $password_old;
    public $password;
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password_old', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute'=>'password_repeat'],
            [['password_old', 'password'], 'string', 'max'=>16, 'min'=>6],
            [['password_old', 'password'], 'match', 'pattern'=> '/^[0-9A-Za-z_-]+$/', 'message'=>'密码请使用字母、数字、下划线、中划线。'],
            ['password', 'validatePassword']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password_old' => '原密码',
            'password' => '新密码',
            'password_repeat' => '确认密码'
        ];
    }

    /**
     * 验证密码
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $id = Yii::$app->user->identity->id;
            $user = User::find($id);
            if (!$user || !$user->validatePassword($this->password_old)) {
                $this->addError('oldpassword', '原始密码不正确');
            }
        }
    }

    /**
     * 修改密码
     * @return bool
     */
    public function changePassword() {
        $id = Yii::$app->user->identity->id;
        $user = User::find($id);
        if (is_null($user)) {
            return false;
        }
        $user->salt = Str::random(10);
        $user->password = $user->generatePassword($this->password);
        return $user->save(false);
    }

}
