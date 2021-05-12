<?php

class Ccc_Practice8_Model_Resource_Practice8_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract{

	public function __construct(){
		$this->setEntity('practice8');
		parent::__construct();
	}
}

?>