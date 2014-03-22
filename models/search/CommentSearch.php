<?php

namespace app\models\search;

use \yii\base\Model;
use \yii\data\ActiveDataProvider;
use app\models\ar\Comment;

/**
 * CommentSearch represents the model behind the search form about `app\models\Comment`.
 */
class CommentSearch extends Model
{
    public $id = 0;
    public $user_id =0;
    public $article_id = 0;
    public $content;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function rules()
    {
        return [
            [['id', 'user_id', 'article_id'], 'integer'],
            [['content', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'content' => '评论内容',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function mySearch($user_id)
    {
        $query = Comment::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->user_id = $user_id;
        $this->addCondition($query, 'user_id');
        return $dataProvider;
    }

    public function search($params)
    {
        $query = Comment::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'user_id');
        $this->addCondition($query, 'article_id');
        $this->addCondition($query, 'content', true);
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'updated_at');
        $this->addCondition($query, 'deleted_at');
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
