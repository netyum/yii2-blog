<?php

namespace app\models\ar;

use app\models\User;
use Carbon\Carbon;
use \Yii;

/**
 * This is the model class for table "yii2_article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property integer $comments_count
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updated_at = new Carbon;
            if ($this->isNewRecord) {
                $this->created_at = new Carbon;
                $this->user_id = Yii::$app->user->identity->id;
                $this->comments_count = 0;
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
            [['category_id', 'title', 'slug', 'content'], 'required'],
            [['category_id', 'user_id', 'comments_count'], 'integer'],
            [['title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug'], 'unique'],
            [['title'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'user_id' => 'User ID',
            'title' => '标题',
            'slug' => 'Slug',
            'content' => '内容',
            'comments_count' => '评论数',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
