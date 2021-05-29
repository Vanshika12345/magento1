<?php  

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Shipping extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	public function _construct()
	{
		$this->setTemplate('order/cart/index/shipping.phtml');
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

	public function getShippingMethodUrl(){
        return $this->getUrl('*/adminhtml_order_cart/updateShipping',array('_current'=>true));
    }

    public function getShippingMethod(){
        $shippingMethods = Mage::getModel('shipping/config')->getActiveCarriers();
        return $shippingMethods;
    }

    public function fetchShippingMethod(){
        return $this->getCart()->getShippingMethod();
    }
}

?>