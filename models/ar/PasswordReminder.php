<?php

namespace app\models\ar;

/**
 * This is the model class for table "yii2_password_reminder".
 *
 * @property string $email
 * @property string $token
 * @property string $created_at
 */
class PasswordReminder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%password_reminder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'token'], 'string'],
            [['created_at'], 'required'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'token' => 'Token',
            'created_at' => 'Created At',
        ];
    }
}
