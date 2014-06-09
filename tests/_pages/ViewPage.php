<?php

namespace tests\_pages;

use yii\codeception\BasePage;

class ViewPage extends BasePage
{
    public $route = array('site/view', 'slug' => 'readme');
}
