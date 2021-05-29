<?php

class Ccc_Order_Model_Order_Address extends Mage_Core_Model_Abstract {

	protected $order = null;

	public function _construct() {
		$this->_init('order/order_address');
	}

	public function setOrder(Ccc_Order_Model_Order $order) {
		$this->order = $order;
		return $this;
	}

	public function getOrder() {
		if ($this->order) {
			return $this->order;
		}
		$order = Mage::getModel('order/order')->load($this->order_id);
		$this->setOrder($order);
		return $this->order;
	}
}