<?php 

class Ccc_Order_Model_Order_Cart_Address extends Mage_Core_Model_Abstract
{

	function _construct()
	{
		$this->_init('order/order_cart_address');
	}

	public function setCart(Ccc_Order_Model_Order_Cart $cart)
	{
		$this->cart = $cart;
		return $this;
	}

	public function getCart()
	{
		if($this->cart)
		{
			return $this->cart;
		}
		$cart = Mage::getModel('order/order_cart')->load($this->cart_id);
		$this->setCart($cart);
		return $this->cart;
	}
}

?>