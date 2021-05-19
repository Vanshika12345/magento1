<?php

class Ccc_Vendor_Block_Product_Grid extends Mage_Core_Block_Template {

	public function __construct() {
		/*$products = Mage::getResourceModel('sales/order_collection')
			            ->addFieldToSelect('*')
			            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())

			        ;
			$this->setCollection($products);
		*/
	}

	public function prepareLayout() {
		parent::prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'product.pager')
			->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		return $this;
	}

	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}

	public function getBackUrl() {
		return $this->getUrl('vendor/account/');
	}

	public function getEditUrl($row) {
		return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
	}

	public function getDeleteUrl($row) {
		return $this->getUrl('*/*/delete', ['id' => $row->getId()]);
	}

	public function getAddUrl() {
		return $this->getUrl('*/*/add');
	}

}

?>