<?php
class Ccc_Vendor_Adminhtml_Vendor_ProductController extends Mage_Adminhtml_Controller_Action {

	public function _getSession() {
		return Mage::getSingleton('adminhtml/session');
	}

	public function indexAction() {
		$this->loadLayout()->_setActiveMenu('vendor');
		$this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_product'));
		$this->renderLayout();
	}

	public function rejectAction() {
		$id = $this->getRequest()->getParam('id');

		$product = Mage::getModel('vendor/product')->load($id);

		if (!$product->getId()) {
			$this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}

		$product->setAdminStatus('reject');
		$product->save();

		$this->_getSession()->addSuccess(Mage::helper('vendor')->__('Vendor Product Save Successfully.'));
		$this->_redirect('*/*/');
	}

	public function approveAction() {
		$id = $this->getRequest()->getParam('id');
		// print_r($id);
		// die();

		try {
			$vendorProduct = Mage::getModel('vendor/product')->load($id);
			// echo "<pre>";
			// print_r($vendorProduct);
			// die();
			$catalogProduct = Mage::getModel('catalog/product');

			if (!$vendorProduct->getId()) {
				$this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists.'));
				$this->_redirect('*/*/');
				return;
			}

			if ($vendorProduct->getVendorStatus() == 'new') {
				$catalogProduct->setData($vendorProduct->getData());
				$catalogProduct->setId(null);
				$catalogProduct->setAttributeSetId(Mage::getSingleton('eav/config')
						->getEntityType('catalog_product')
						->getDefaultAttributeSetId());
				$catalogProduct->save();
				$vendorProduct->setProductId($catalogProduct->getId());
			} else if ($vendorProduct->getVendorStatus() == 'edit') {
				$catalogProduct->load($vendorProduct->getProductId());
				$catalogProduct->setData($vendorProduct->getData());
				$catalogProduct->setId(null);
				$catalogProduct->setAttributeSetId(Mage::getSingleton('eav/config')
						->getEntityType('catalog_product')
						->getDefaultAttributeSetId());
				$catalogProduct->save();
			} else if ($vendorProduct->getVendorStatus() == "delete") {
				if ($vendorProduct->load($Id)) {
					$vendorProduct->delete();
				}
			}

			$vendorProduct->setAdminStatus('approve');
			$vendorProduct->save();
			Mage::getSingleton('adminhtml/session')->addSuccess('Product Approve Successfully.');
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		$this->_redirect('*/*/');
	}
}

?>