<?php

namespace tests\unit\fixtures\ar;


use yii\test\ActiveFixture;


class CommentFixture extends ActiveFixture
{
	public $modelClass = 'app\models\ar\Comment';
	public $depends = [
		'tests\unit\fixtures\UserFixture',
		'tests\unit\fixtures\ArticleFixture',
	];
	
}