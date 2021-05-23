<?php
class Ccc_Vendor_Model_Product extends Mage_Catalog_Model_Product {
	const ENTITY = 'vendor_product';

	const CACHE_TAG = 'vendor_product';
	protected $_cacheTag = 'vendor_product';
	protected $_eventPrefix = 'vendor_product';
	protected $_eventObject = 'vendor_product';

	protected function _construct() {
		parent::_construct();
		$this->_init('vendor/product');
	}

	public function getAttributes() {
		if ($this->_attributes === null) {
			$this->_attributes = $this->_getResource()
				->loadAllAttributes($this)
				->getSortedAttributes();
		}
		return $this->_attributes;
	}

	public function checkInGroup($attributeId, $setId, $groupId) {
		$resource = Mage::getSingleton('core/resource');

		$readConnection = $resource->getConnection('core_read');

		$query = "SELECT * FROM
            {$resource->getTableName('eav/entity_attribute')}
            WHERE `attribute_id` = '{$attributeId}'
            AND `attribute_group_id` = '{$groupId}'
            AND `attribute_set_id` = '{$setId}'";
		$result = $readConnection->fetchRow($query);

		if ($result) {
			return true;
		}
		return false;
	}

	public function setOrigData($key = null, $data = null) {
		return Mage_Catalog_Model_Abstract::setOrigData($key, $data);
	}
}

?>