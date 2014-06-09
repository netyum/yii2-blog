<?php

$I = new TestGuy($scenario);
$I->wantTo('保证site/index页面正常工作');
$I->amOnPage(Yii::$app->homeUrl);
$I->seeLink('Yii2 Blog');
$I->seeLink('首页');
$I->seeLink('yii2-blog说明');
$I->click('yii2-blog说明');
$I->see('yii2-blog说明');
