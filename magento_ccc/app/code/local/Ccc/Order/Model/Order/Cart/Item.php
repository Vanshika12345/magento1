<?php 

class Ccc_Order_Model_Order_Cart_Item extends Mage_Core_Model_Abstract
{

	protected $product;
	protected $cart;
	function _construct()
	{
		$this->_init('order/order_cart_item');
	}

	public function setProduct(Mage_Catalog_Model_Product $product)
	{
		$this->product = $product;
		return $this;	
	}
	public function getProduct()
	{
		if($this->product)
		{
			return null;
		}
		$product = Mage::getModel('catalog/product')->load($this->product_id);
		$this->setProduct($product);
		return $this->product;
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