<?php

namespace tests\_pages;

use yii\codeception\BasePage;

class SigninPage extends BasePage
{
    public $route = 'auth/sign-in';

    public function login($email, $password)
    {
        $this->guy->fillField('input[name="SignInForm[email]"]', $email);
        $this->guy->fillField('input[name="SignInForm[password]"]', $password);
        $this->guy->click('login-button');
    }
}
