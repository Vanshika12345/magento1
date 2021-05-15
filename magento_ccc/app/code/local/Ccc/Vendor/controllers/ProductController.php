<?php

class Ccc_Vendor_ProductController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_initLayoutMessages('vendor/session');
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();
	}

	public function _getSession() {
		return Mage::getSingleton('vendor/session');
	}

	public function addAction() {
		$this->_forward('edit');
	}

	public function deleteAction() {

	}

	public function editAction() {

		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveAction() {

	}

}

?>