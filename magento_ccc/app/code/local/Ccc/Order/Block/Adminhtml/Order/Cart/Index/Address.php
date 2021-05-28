<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Address extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	public function _construct()
	{
		$this->setTemplate('order/cart/index/address.phtml');
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

	public function getCartShippingAddress()
	{
		$cart = $this->getCart();
		$session = Mage::getModel('order/session');
		$cartId = $session->cartId;
		$customerId = $session->customerId;
		$cart = $cart->load($customerId, 'customer_id');
		if ($cart->getId()) {
			$shippingAddress = $cart->getBillingAddress();
			if ($shippingAddress->getData()) {
				return $shippingAddress;
			}
			$customerShippingAddress = Mage::getModel('customer/customer')->load($customerId)->getPrimaryShippingAddress();
			$cartshippingAddress = Mage::getModel('order/order_cart_address');
			if ($customerShippingAddress) {
				$shippingAddressData = $customerShippingAddress->getData();
					unset($shippingAddressData['customer_id']);
			 		$cartshippingAddress->address_type = 2;
			 		$cartshippingAddress->cart_id = $cart->cart_id;
			 		$cartshippingAddress->street = $shippingAddressData['street'];
			 		$cartshippingAddress->city = $shippingAddressData['city'];
			 		$cartshippingAddress->country_id = $shippingAddressData['country_id'];
			 		$cartshippingAddress->region = $shippingAddressData['region'];
			 		$cartshippingAddress->postcode = $shippingAddressData['postcode'];
					$cartshippingAddress->save();
					return $cartshippingAddress;
			}	
		}
	}

	public function getCartBillingAddress() {
		$cart = $this->getCart();
		$session = Mage::getModel('order/session');
		$cartId = $session->cartId;
		$customerId = $session->customerId;
		$cart = $cart->load($customerId, 'customer_id');
		if ($cart->getId()) {
			$billingAddress = $cart->getBillingAddress();
			if ($billingAddress->getData()) {
				return $billingAddress;
			}
			$customerBillingAddress = Mage::getModel('customer/customer')->load($customerId)->getDefaultBillingAddress();
			$cartbillingAddress = Mage::getModel('order/order_cart_address');
			if ($customerBillingAddress) {
				$billingAddressData = $customerBillingAddress->getData();
					unset($billingAddressData['customer_id']);
			 		$cartbillingAddress->address_type = 1;
			 		$cartbillingAddress->cart_id = $cart->cart_id;
			 		$cartbillingAddress->street = $billingAddressData['street'];
			 		$cartbillingAddress->city = $billingAddressData['city'];
			 		$cartbillingAddress->country_id = $billingAddressData['country_id'];
			 		$cartbillingAddress->region = $billingAddressData['region'];
			 		$cartbillingAddress->postcode = $billingAddressData['postcode'];
					$cartbillingAddress->save();
					return $cartbillingAddress;
			}
		}
	}

	
}


?>