<?php

use tests\_pages\AdminCategoryPage;
use tests\_pages\SigninPage;

$I = new TestGuy($scenario);
$I->wantTo('保证admin/category/index页面正常工作');
AdminCategoryPage::openBy($I);

$I->see('用户登录');

$signinPage = SigninPage::openBy($I);
$I->amGoingTo('尝试使用正确的邮箱和正确的密码登录');
$signinPage->login('admin@yiibook.com', 'yiibook');
$I->expectTo('查看用户信息');
$I->see('[ admin@yiibook.com]');

AdminCategoryPage::openBy($I);

$I->see('文章分类管理', 'h3');

