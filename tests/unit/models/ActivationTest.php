<?php

namespace tests\unit\models;

use Yii;
use yii\codeception\DbTestCase;

use tests\unit\fixtures\ar\ActivationFixture;
use tests\unit\fixtures\InitDbFixture;

use app\models\ar\Activation;
use app\models\User;
use Carbon\Carbon;

class ActivationTest extends DbTestCase
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
			'activation' => ActivationFixture::className()
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

    public function testActivation()
    {
		$activationCode = $this->activation['one']['token'];
        // 数据库验证令牌
        $activation = Activation::findOne(['token'=>$activationCode]);
		$this->assertNotEmpty($activation);
		
		// 激活对应用户
		$sql = "UPDATE {{%user}} SET activated_at=:activated_at WHERE email=:email";
		$command = Yii::$app->db->createCommand($sql);
		$command->bindValue(':activated_at', new Carbon);
		$command->bindValue(':email', $activation->email);
		$ret = $command->execute();
		$this->assertNotEquals(0, $ret);
        $this->assertNotEquals(0, $activation->delete());
    }
}
