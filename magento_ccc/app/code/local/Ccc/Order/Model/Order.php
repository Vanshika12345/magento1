<?php

class Ccc_Order_Model_Order extends Mage_Core_Model_Abstract{

	protected $customer = null;
	protected $shippingMethods = null;
	protected $paymentMethods = null;
	protected $orderItems = null;
	protected $orderBillingAddress = null;
	protected $orderShippingAddress = null;
	
	protected function _construct(){
		$this->_init('order/order');
	}

	public function setCustomer(Mage_Customer_Model_Customer $customer)
	{
		$this->customer = $customer;
	}

	public function getCustomer()
	{
		if($this->customer){
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

	public function setOrderBillingAddress(Ccc_Order_Model_Order_Address $orderBillingAddress) {
		$this->orderBillingAddress = $orderBillingAddress;
		return $this;
	}

	public function getOrderBillingAddress() {
		if ($this->orderBillingAddress) {
			return $this->orderBillingAddress;
		}
		if (!$this->order_id) {
			return false;
		}
		$address = Mage::getModel('order/order_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->order_id])
			->addFieldToFilter('address_type', ['eq' => 1]);
		$address = $addressCollection->getFirstItem();
		$this->setOrderBillingAddress($address);
		return $address;
	}

	public function setOrderShippingAddress(Ccc_Order_Model_Order_Address $orderShippingAddress) {
		$this->orderShippingAddress = $orderShippingAddress;
		return $this;
	}

	public function getOrderShippingAddress() {
		if ($this->orderShippingAddress) {
			return $this->orderShippingAddress;
		}
		if (!$this->order_id) {
			return false;
		}
		$address = Mage::getModel('order/order_address');
		$addressCollection = $address->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->order_id])
			->addFieldToFilter('address_type', ['eq' => 2]);
		$address = $addressCollection->getFirstItem();
		$this->setOrderShippingAddress($address);
		return $address;
	}

	public function setItems(Ccc_Order_Model_Order_Item $orderItems) {
		$this->orderItems = $orderItems;
		return $this;
	}

	public function getItems() {
		if ($this->orderItems) {
			return $this->orderItems;
		}
		if (!$this->order_id) {
			return false;
		}
		$collection = Mage::getModel('order/order_item')->getCollection()
			->addFieldToFilter('order_id', ['eq' => $this->order_id]);
		return $collection;
	}
}

?>