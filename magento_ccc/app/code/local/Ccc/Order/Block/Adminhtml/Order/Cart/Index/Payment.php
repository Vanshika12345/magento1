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

	public function getPaymentMethod(){
        $paymentMethods = Mage::getModel('payment/config')->getActiveMethods();
        return $paymentMethods;
    }

	public function getPaymentMethodUrl(){
        return $this->getUrl('*/adminhtml_order_cart/updatePayment',array('_current'=>true));
    }

    public function fetchPaymentMethod(){
        return $this->getCart()->getPaymentMethod();
    }
}

?>