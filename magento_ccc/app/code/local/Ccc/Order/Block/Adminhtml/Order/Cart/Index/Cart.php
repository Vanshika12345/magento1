<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Cart extends Mage_Adminhtml_Block_Template
{
	
	public function _construct()
	{
		$this->setTemplate('order/cart/index/cart.phtml');
	}

	public function getCart()
	{
		$session = Mage::getModel('order/session');
		return Mage::getModel('order/order_cart')->load($session->cartId);
	}
	public function getItemObject()
	{	
		$cartId = Mage::getModel('order/session')->cartId;
		return Mage::getModel('order/order_cart_item')->load($cartId,'cart_id');
	}
}


?>