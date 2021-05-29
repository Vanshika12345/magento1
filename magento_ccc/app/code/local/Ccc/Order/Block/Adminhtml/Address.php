<?php 

class Ccc_Order_Block_Adminhtml_Address extends Mage_Core_Block_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/address.phtml');
	}

	public function getOrderShippingAddress()
	{
		$orderId = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('order/order')->load($orderId);
		if ($order) {
			$shippingAddress = $order->getShippingAddress();
			if ($shippingAddress) {
				return $shippingAddress;
			}
		}
	}

	public function getOrderBillingAddress()
	{
		$orderId = $this->getRequest()->getParam('order_id');;	
		$order = Mage::getModel('order/order')->load($orderId);
		if ($order) {
			$billingAddress = $order->getBillingAddress();
			if ($billingAddress) {
				return $billingAddress;
			}
		} 
	}

	
}

/**/

?>