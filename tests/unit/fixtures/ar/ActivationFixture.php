<?php

namespace tests\unit\fixtures\ar;


use yii\test\ActiveFixture;


class ActivationFixture extends ActiveFixture
{
	public $modelClass = 'app\models\ar\Activation';
	public $depends = ['tests\unit\fixtures\UserFixture'];
}