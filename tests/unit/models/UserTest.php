<?php

namespace tests\unit\models;

use Yii;
use yii\codeception\DbTestCase;

use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\InitDbFixture;

use app\models\User;
use Carbon\Carbon;

class UserTest extends DbTestCase
{
    public function globalFixtures()
    {   
        return [
            InitDbFixture::className(),
        ];
    } 
	
	public function fixtures()
	{
		return [
			'user' => UserFixture::className()
		];
	}
		
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testValidatePassword()
    {
		$user = new User;
		$user->load($this->user['user1'], false);
        $this->assertTrue($user->validatePassword("yiibook"));
    }
}
