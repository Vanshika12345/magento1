<?php 

class Ccc_Order_Block_Adminhtml_Payment extends Mage_Core_Block_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/payment.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}

	public function getPaymentMethod()
	{
		return $this->getOrder()->getPaymentMethod();
	}

	public function getPaymentName()
	{
		//$code = $this->getShipmentMethod();
		$config = Mage::getModel('payment/config')->getActiveMethods();
		return $config;
	}
}


?>