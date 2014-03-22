<?php

namespace app\models\ar;

use \Yii;
use \Carbon\Carbon;
/**
 * This is the model class for table "yii2_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
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
            [['sort_order', 'name'], 'required'],
            [['name'], 'string'],
            [['sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sort_order' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }


    public static function getCategories() {
        $sql = "SELECT id, name FROM {{%category}} ORDER BY sort_order ASC";
        $categories = Yii::$app->db->createCommand($sql)->queryAll();
        return $categories;
    }

}
