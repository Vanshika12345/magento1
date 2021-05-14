<?php


class Ccc_Practice8_Model_Attribute extends Mage_Eav_Model_Attribute{

	const MODULE_NAME = 'Ccc_Practice8';
	protected $_eventObject = 'attribute';
	
	protected function _construct(){
		$this->_init('practice8/attribute');
	}
	
}
?>