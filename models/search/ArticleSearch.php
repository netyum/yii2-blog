<?php

namespace app\models\search;

use \yii\base\Model;
use \yii\data\ActiveDataProvider;
use app\models\ar\Article;

/**
 * ArticleSearch represents the model behind the search form about `app\models\Article`.
 */
class ArticleSearch extends Model
{
    public $id;
    public $category_id;
    public $user_id;
    public $title;
    public $slug;
    public $content;
    public $content_format;
    public $comments_count;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function rules()
    {
        return [
            [['id', 'category_id', 'user_id', 'comments_count'], 'integer'],
            [['title', 'slug', 'content', 'content_format', 'meta_title', 'meta_description', 'meta_keywords', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'content_format' => 'Content Format',
            'comments_count' => 'Comments Count',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function search($params)
    {
        $query = Article::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'category_id');
        $this->addCondition($query, 'user_id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'slug', true);
        $this->addCondition($query, 'content', true);
        $this->addCondition($query, 'content_format', true);
        $this->addCondition($query, 'comments_count');
        $this->addCondition($query, 'meta_title', true);
        $this->addCondition($query, 'meta_description', true);
        $this->addCondition($query, 'meta_keywords', true);
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
