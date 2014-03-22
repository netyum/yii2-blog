<?php

namespace app\models\search;

use \yii\base\Model;
use \yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends Model
{
    public $id;
    public $email;
    public $password;
    public $portrait;
    public $is_admin;
    public $signin_at;
    public $activated_at;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function rules()
    {
        return [
            [['id', 'is_admin'], 'integer'],
            [['email', 'password', 'portrait', 'signin_at', 'activated_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
            'password' => 'Password',
            'portrait' => 'Portrait',
            'is_admin' => 'Is Admin',
            'signin_at' => 'Signin At',
            'activated_at' => 'Activated At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function search($params)
    {
        $query = User::find();
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
        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'password', true);
        $this->addCondition($query, 'portrait', true);
        $this->addCondition($query, 'is_admin');
        $this->addCondition($query, 'signin_at');
        $this->addCondition($query, 'activated_at');
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
