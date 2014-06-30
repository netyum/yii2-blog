<?php

namespace tests\_pages;

use yii\codeception\BasePage;

class CategoryPage extends BasePage
{
    public $route = array('site/index', 'category' => 1);
}
