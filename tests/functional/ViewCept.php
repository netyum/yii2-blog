<?php

use tests\_pages\ViewPage;

$I = new TestGuy($scenario);
$I->wantTo('保证site/view?slug=readme页面正常工作');
ViewPage::openBy($I);
$I->see('yii2-blog说明', 'h2');
