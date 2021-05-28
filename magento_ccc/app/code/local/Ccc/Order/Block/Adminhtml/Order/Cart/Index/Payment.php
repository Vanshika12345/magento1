<?php  

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Payment extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	public function _construct()
	{
		$this->setTemplate('order/cart/index/payment.phtml');
	}

	public function setCart(Ccc_Order_Model_Order_Cart $cart)
	{
		$this->cart = $cart;
		return $this;
	}
	public function getCart()
	{
		return $this->cart;
	}
}

?>