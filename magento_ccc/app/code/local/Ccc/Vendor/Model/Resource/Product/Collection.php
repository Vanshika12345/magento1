<?php

class Ccc_Vendor_Model_Resource_Product_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract {
	const ENTITY = 'vendor_product';

	function __construct() {
		$this->setEntity(self::ENTITY);
		parent::__construct();
	}
}

?>