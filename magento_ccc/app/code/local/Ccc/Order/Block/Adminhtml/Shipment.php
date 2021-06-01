<?php 

class Ccc_Order_Block_Adminhtml_Shipment extends Mage_Core_Block_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/shipment.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}

	public function getShipmentMethod()
	{
		return $this->getOrder()->getShippingMethod();
	}

	public function getShipmentName()
	{
		//$code = $this->getShipmentMethod();
		$config = Mage::getModel('shipping/config')->getActiveCarriers();
		return $config;
	}
}


?>