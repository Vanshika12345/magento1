<?php
class Ccc_Vendor_Block_Product_Grid extends Mage_Core_Block_Template {

	public function getProducts() {
		$collection = Mage::getModel('vendor/product')->getCollection()
			->addAttributeToSelect('price')
			->addAttributeToSelect('name')
			->addAttributeToSelect('status')
			->addAttributeToSelect('vendor_status');

		// echo "<pre>";

		// print_r($collection->getData());
		// die();
		//$adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;

		$collection->joinAttribute('vendor_status', 'vendor_product/vendor_status', 'entity_id', null, 'inner')->addFieldToFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$collection->joinAttribute('admin_status', 'vendor_product/admin_status', 'entity_id', null, 'left')->addFieldToFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$collection->joinAttribute('price', 'vendor_product/price', 'entity_id', null, 'inner')->addFieldToFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$collection->joinAttribute('name', 'vendor_product/name', 'entity_id', null, 'inner')->addFieldToFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		//$collection->joinAttribute('admin_status', 'vendor_product/admin_status', 'entity_id', null, 'inner');

		// echo "<pre>";

		// print_r($collection->getData());
		// die();

		return $collection;
	}
}
?>