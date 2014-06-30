<?php

namespace tests\unit\fixtures\ar;


use yii\test\ActiveFixture;


class ArticleFixture extends ActiveFixture
{
	public $modelClass = 'app\models\ar\Article';
	public $depends = [
		'tests\unit\fixtures\UserFixture',
		'tests\unit\fixtures\CategoryFixture',
	];
}