<?php

class Ccc_Vendor_Model_Group extends Mage_Core_Model_Abstract {

	protected function _construct() {
		$this->_init('vendor/group');
	}

	public function validateGroup($data) {
		$collection = Mage::getResourceModel('vendor/group_collection')
			->addFieldToSelect('*')
			->addFieldToFilter('vendor_id', Mage::getSingleton('vendor/session')->getVendor()->getId())
			->addFieldToFilter('group_name', $data);
		if (empty($collection->getData())) {
			return true;
		}
		return false;

	}
}

?>