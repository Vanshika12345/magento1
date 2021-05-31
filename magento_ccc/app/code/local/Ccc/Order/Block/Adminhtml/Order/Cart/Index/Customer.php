<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Customer extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	public function _construct()
	{
		$this->setTemplate('order/cart/customer.phtml');
	}

	public function setCart(Ccc_Order_Model_Order_Cart $cart)
	{
		$this->cart = $cart;
	}
	public function getCart()
	{
		return $this->cart;
	}

	public function getCustomers()
	{
		$customer = Mage::getModel('customer/customer')->getCollection();
		$customer->addNameToSelect();
		return $customer;
	}
}


?>