<?php

namespace app\models\ar;

/**
 * This is the model class for table "yii2_activation".
 *
 * @property integer $id
 * @property string $email
 * @property string $token
 * @property string $created_at
 */
class Activation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%activation}}';
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
            'id' => 'ID',
            'email' => 'Email',
            'token' => 'Token',
            'created_at' => 'Created At',
        ];
    }
}
