<?php

class Ccc_Practice2_Block_Adminhtml_Practice2 extends Mage_Adminhtml_Block_Widget_Grid_Container{


	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_practice2';
		$this->_blockGroup = 'practice2';
		$this->_headerText = 'Manage Practice2';
	}
}

?>