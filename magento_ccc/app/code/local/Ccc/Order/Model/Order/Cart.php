<?php

class Ccc_Order_Model_Order_Cart extends Mage_Core_Model_Abstract {

	protected $customer = null;
	protected $shippingMethods = null;
	protected $paymentMethods = null;
	protected $cartShippingAddress = null;
	protected $cartBillingAddress = null;
	protected $cartItems = null;

	public function _construct() {
		$this->_init('order/order_cart');
	}

	public function setCustomer(Mage_Customer_Model_Customer $customer) {
		$this->customer = $customer;
		return $this;
	}

	public function getCustomer() {
		if ($this->customer) {
			return $this->customer;
		}
		$customer = Mage::getModel('customer/customer')->load($this->customer_id);
		$this->setCustomer($customer);
		return $this->customer;
	}

	public function setShippingMethod($shippingMethod) {
		$this->shippingMethods = $shippingMethod;
		return $this;
	}

	public function getShippingMethod() {
		if ($this->shippingMethods) {
			return $this->shippingMethods;
		}
		$shippingMethods = $this->getShipmentCode();
		$this->setShippingMethod($shippingMethods);
		return $this->shippingMethods;
	}

	public function setPaymentMethod($paymentMethods) {
		$this->paymentMethods = $paymentMethods;
		return $this;
	}

	public function getPaymentMethod() {
		if ($this->paymentMethods) {
			return $this->paymentMethods;
		}
		$paymentMethods = $this->getPaymentCode();
		$this->setPaymentMethod($paymentMethods);
		return $this->paymentMethods;
	}

	public function setCartBillingAddress(Ccc_Order_Model_Order_Cart_Address $cartBillingAddress) {
		$this->cartBillingAddress = $cartBillingAddress;
		return $this;
	}

	public function getCartBillingAddress() {
		if ($this->cartBillingAddress) {
			return $this->cartBillingAddress;
		}
		if (!$this->cart_id) {
			return false;
		}
		$address = Mage::getModel('order/order_cart_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->cart_id])
			->addFieldToFilter('address_type', ['eq' => 1]);
		$address = $addressCollection->getFirstItem();
		$this->setCartBillingAddress($address);
		return $address;
	}

	public function setCartShippingAddress(Ccc_Order_Model_Order_Cart_Address $cartShippingAddress) {
		$this->cartShippingAddress = $cartShippingAddress;
		return $this;
	}

	public function getCartShippingAddress() {
		if ($this->cartShippingAddress) {
			return $this->cartShippingAddress;
		}
		if (!$this->cart_id) {
			return false;
		}
		$address = Mage::getModel('order/order_cart_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->cart_id])
			->addFieldToFilter('address_type', ['eq' => 2]);
		$address = $addressCollection->getFirstItem();
		$this->setCartShippingAddress($address);
		return $address;
	}

	public function setItems(Ccc_Order_Model_Order_Cart_Item $cartItems) {
		$this->cartItems = $cartItems;
		return $this;
	}

	public function getItems() {
		if ($this->cartItems) {
			return $this->cartItems;
		}
		if (!$this->cart_id) {
			return false;
		}
		$collection = Mage::getModel('order/order_cart_item')->getCollection()
			->addFieldToFilter('cart_id', ['eq' => $this->cart_id]);
		return $collection;
	}

}