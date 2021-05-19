<?php
class Ccc_Vendor_Model_Resource_Product extends Mage_Catalog_Model_Resource_Product {
	const ENTITY = 'vendor_product';

	public function __construct() {

		parent::__construct();
		$this->setType(self::ENTITY)
			->setConnection('core_read', 'core_write');

		
	}

}
?>