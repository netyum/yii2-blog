<?php
namespace tests\unit\fixtures;

use yii\test\InitDbFixture as DbFixture;

class InitDbFixture extends DbFixture
{
    public function checkIntegrity($check)
    {
		if ($this->db->driverName != 'sqlite') {
        	foreach ($this->schemas as $schema) {
        		$this->db->createCommand()->checkIntegrity($check, $schema)->execute();
        	}
		}
    }
}