<?php

namespace app\models;

use \Yii;
use \Carbon\Carbon;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }


    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_at = new Carbon;
            if ($this->isNewRecord) {
                $this->created_at = new Carbon;
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute'=>'password_repeat'],
            ['password', 'string', 'max'=>16, 'min'=>6],
            ['password', 'match', 'pattern'=> '/^[0-9A-Za-z_-]+$/', 'message'=>'密码请使用字母、数字、下划线、中划线。'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=>'app\models\User', 'message'=>'邮箱"{value}"已经被注册，请更换'],
            [['is_admin', 'signin_at', 'activated_at', 'created_at', 'updated_at', 'salt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => '邮箱',
            'password' => '密码',
            'password_repeat' => '确认密码',
            'portrait' => 'Portrait',
            'is_admin' => '身份',
            'signin_at' => '最后登录时间',
            'activated_at' => 'Activated At',
            'created_at' => '注册时间',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 小图
     * @return string
     */
    public function getPortraitSmall()
    {
        return $this->portrait ?
            $this->getPortrait('small') : $this->getIdenticon(64);
    }

    /**
     * 中图
     * @return string
     */
    public function getPortraitMedium()
    {
        return $this->portrait ?
                $this->getPortrait('medium') : $this->getIdenticon(128);
    }

    /**
     * 大图
     * @return string
     */
    public function getPortraitLarge()
    {
        return $this->portrait ?
            $this->getPortrait('large') : $this->getIdenticon(220);
    }

    /**
     * 生成头像图标
     * @param $size
     * @return string
     */
    protected function getIdenticon($size) {
        $identicon = new \Identicon\Identicon;
        return $identicon->getImageDataUri($this->email, $size);
    }

    /**
     * 获得头像
     * @param string $size
     * @return string
     */
    protected function getPortrait($size='') {
        $path = Yii::getAlias("@web/");
        if ($size=='') {
            $img = $path.'portrait/'.$this->portrait;
        }
        else {
            $img = $path.'portrait/'. $size .'/'. $this->portrait;
        }
        return $img;
    }

    /**
     * @param $email
     * @param bool $isModel
     * @return null|static
     */
    public static function findByEmail($email, $isModel=false)
    {
        $user = self::find()->where(['email'=>$email])->one();

        if ($user) {
            if ($isModel) return $user;
            else return new static($user);
        }
        else
            return null;
    }


    public function getIsAdmin() {
        return $this->is_admin == 1;
    }

    /**
     *
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->generatePassword($password)===$this->password;
    }

    /**
     * 生成密码
     * @param $password
     * @return string
     */
    public function generatePassword($password)
    {
        return sha1($password.$this->salt);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = self::find($id);
        if ($user) {
            return new static($user);
        }
        else
            return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token)
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool|null
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

}
