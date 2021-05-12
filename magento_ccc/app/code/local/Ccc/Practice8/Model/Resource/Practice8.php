<?php

class Ccc_Practice8_Model_Resource_Practice8 extends Mage_Eav_Model_Entity{

	const ENTITY = 'practice8';

	public function __construct()
	{
		$this->setType(self::ENTITY)->setConnection('core_read','core_write');
		parent::__construct();
	}
}

?>