<?php

namespace app\models\ar;

use app\models\User;

/**
 * This is the model class for table "yii2_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $article_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'content', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'article_id'], 'integer'],
            [['content'], 'string', 'min' => 3],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论ID',
            'user_id' => '用户ID',
            'article_id' => '文章ID',
            'content' => '评论内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
