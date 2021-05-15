<?php

class Ccc_Vendor_Model_Product extends Mage_Core_Model_Abstract {

	const ENTITY = 'vendor_product';

	protected function _construct() {
		$this->_init('vendor/product');
	}

	public function checkInGroup($attributeId, $setId, $groupId) {
		$resource = Mage::getSingleton('core/resource');

		$readConnection = $resource->getConnection('core_read');
		//$readConnection = $resource->getConnection('core_read');

		$query = '
            SELECT * FROM ' .
		$resource->getTableName('eav/entity_attribute')
			. ' WHERE `attribute_id` =' . $attributeId
			. ' AND `attribute_group_id` =' . $groupId
			. ' AND `attribute_set_id` =' . $setId
		;

		$results = $readConnection->fetchRow($query);
		if ($results) {
			return true;
		}
		return false;
	}

	/*public function setOrigData($key = null, $data = null) {
        return Mage_Catalog_Model_Abstract::setOrigData($key, $data);
    }*/
}

?>