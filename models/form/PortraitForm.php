<?php

namespace app\models\form;

use \Yii;
use yii\base\Model;
use \yii\imagine\Image;
use app\models\User;

/**
 * PortraitForm is the model behind the login form.
 */
class PortraitForm extends Model
{
    public $portrait;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['portrait', 'required'],
            ['portrait', 'file', 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 2 * 1024 * 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'portrait' => '头像',
        ];
    }


    public function changePortrait(){

        $user = User::findOne(Yii::$app->user->identity->id);
        if (is_null($user)) {
            $this->addError('portrait', '用户不存在');
            return false;
        }

        $path = Yii::getAlias("@webroot/portrait/");
        $largePath = Yii::getAlias("@webroot/portrait/large/");
        $mediumPath = Yii::getAlias("@webroot/portrait/medium/");
        $smallPath = Yii::getAlias("@webroot/portrait/small/");


        //保存新头像
        $filename = date('H.i.s') .'-'. md5($this->portrait->name) .'.'. $this->portrait->extension;
        $this->portrait->saveAs($path.$filename);
        //large
        Image::thumbnail($path.$filename, 220, 220)->save($largePath.$filename);
        //medium
        Image::thumbnail($path.$filename, 128, 128)->save($mediumPath.$filename);
        //small
        Image::thumbnail($path.$filename, 64, 64)->save($smallPath.$filename);

        //删除原头像
        $oldFilename = $user->portrait;
        @unlink($path.$oldFilename);
        @unlink($largePath.$oldFilename);
        @unlink($mediumPath.$oldFilename);
        @unlink($smallPath.$oldFilename);

        //保存新头像名到数据库
        $user->portrait = $filename;
        if (!$user->save(false)) {
            $this->addError('portrait', '头像修改失败');
            return false;
        }
        return true;
    }
}
