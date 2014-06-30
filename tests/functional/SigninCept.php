<?php

use tests\_pages\SigninPage;

$I = new TestGuy($scenario);
$I->wantTo('保证auth/sign-in页面正常工作');

$signinPage = SigninPage::openBy($I);

$I->see('用户登录', 'h2');

$I->amGoingTo('尝试使用空的邮箱密码登录');
$signinPage->login('', '');
$I->expectTo('看验证错误');
$I->see('邮箱不能为空');

$I->amGoingTo('尝试使用错误的邮箱格式和空密码');
$signinPage->login('admin', '');
$I->expectTo('看验证错误');
$I->see('密码不能为空。');

$I->amGoingTo('尝试使用错误的邮箱格式和非空密码');
$signinPage->login('admin', 'wrong');
$I->expectTo('看验证错误');
$I->see('邮箱不是有效的邮箱地址。');

$I->amGoingTo('尝试使用正确的邮箱格式和空密码');
$signinPage->login('admin@163.com', '');
$I->expectTo('看验证错误');
$I->see('密码不能为空。');

$I->amGoingTo('尝试使用正确的邮箱格式和非空密码');
$signinPage->login('admin@163.com', 'wrong');
$I->expectTo('看验证错误');
$I->see('密码应该包含至少6个字符。');

$I->amGoingTo('尝试使用正确的邮箱格式和够长非空密码');
$signinPage->login('admin@163.com', '123456');
$I->expectTo('看验证错误');
$I->see('无效的邮箱或密码');


$I->amGoingTo('尝试使用存在的邮箱和错误的密码登录');
$signinPage->login('admin@yiibook.com', '123456');
$I->expectTo('看验证错误');
$I->see('无效的邮箱或密码');

$I->amGoingTo('尝试使用正确的邮箱和正确的密码登录');
$signinPage->login('admin@yiibook.com', 'yiibook');
$I->expectTo('查看用户信息');
$I->see('[ admin@yiibook.com]');