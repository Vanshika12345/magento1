<?php

class Ccc_Order_Block_Adminhtml_Order extends Mage_Adminhtml_Block_Widget_Grid_Container{


	public function __construct()
	{
		$this->_controller = 'adminhtml_order';
		$this->_blockGroup = 'order';
		$this->_headerText = "Manage Orders";
		$this->_addButtonLabel = Mage::helper('order')->__('Create New Order');
		parent::__construct();
	}

	public function getCreateUrl()
	{
		return $this->getUrl('*/adminhtml_order/customerGrid');
	}
}
?>