<?php

class Ccc_Vendor_Model_Resource_Product extends Mage_Catalog_Model_Resource_Product {

	const ENTITY = 'vendor_product';

	public function __construct() {
		parent::__construct();
		$this->setType(Ccc_Vendor_Model_Product::ENTITY)
			->setConnection('core_read', 'core_write');
		// $this->_productWebsiteTable  = $this->getTable('vendor/product_website');
		// $this->_productCategoryTable = $this->getTable('vendor/category_product');
	}

	protected function _getDefaultAttributes() {
		return array('entity_id', 'entity_type_id', 'attribute_set_id', 'type_id', 'created_at', 'updated_at');
	}
}
?>