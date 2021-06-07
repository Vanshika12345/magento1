<?php 

class Ccc_Order_Model_Order_Status extends Mage_Core_Model_Abstract {

	protected $order = null;
	
	public function _construct() {
		$this->_init('order/order_status');
	}

	public function setOrder(Ccc_Order_Model_Order $order) {
		$this->order = $order;
		return $this;
	}

	public function getOrder() {
		if (!$this->order) {
			return false;
		}
		$order = Mage::getModel('order/order')->load($this->order_id);
		$this->setOrder($order);
		return $this->order;
	}
}
?>