<?php

class Ccc_Vendor_Model_Resource_Product extends Mage_Catalog_Model_Resource_Product {

	const ENTITY = 'vendor_product';

	public function __construct() {
		parent::__construct();
		$this->setType(Ccc_Vendor_Model_Product::ENTITY)
			->setConnection('core_read', 'core_write');
	}

	protected function _getDefaultAttributes() {
		return array('entity_id', 'entity_type_id', 'attribute_set_id', 'type_id', 'created_at', 'updated_at');
	}

	public function getSkuById($sku) {
		$adapter = $this->_getReadAdapter();

		$select = $adapter->select()
			->from($this->getEntityTable(), 'entity_id')
			->where('sku = :sku');

		$bind = array(':sku' => (string) $sku);

		return $adapter->fetchOne($select, $bind);
	}

	protected function _getReadAdapter() {
		if (is_string($this->_read)) {
			$this->_read = Mage::getSingleton('core/resource')->getConnection($this->_read);
		}
		return $this->_read;
	}
}
?>