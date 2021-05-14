<?php

class Ccc_Practice8_Block_Adminhtml_Practice8 extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_practice8';
		$this->_blockGroup = 'practice8';
		$this->_headerText = 'Manage Practice8';
	}
}
?>