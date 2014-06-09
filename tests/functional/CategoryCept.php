<?php

use tests\_pages\CategoryPage;

$I = new TestGuy($scenario);
$I->wantTo('保证site/index?category=1页面正常工作');
CategoryPage::openBy($I);
$I->seeLink('yii2相关');
