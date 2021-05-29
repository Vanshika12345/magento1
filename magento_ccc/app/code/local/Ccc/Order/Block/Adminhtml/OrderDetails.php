<?php  


class Ccc_Order_Block_Adminhtml_OrderDetails extends Mage_Core_Block_Template
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/orderdetails.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}
}

?>