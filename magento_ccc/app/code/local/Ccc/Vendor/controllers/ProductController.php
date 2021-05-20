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

	protected function _initProduct()
    {
        $this->_title($this->__('Vendor'))
             ->_title($this->__('Manage Products'));

        $productId  = (int) $this->getRequest()->getParam('id');
        $product    = Mage::getModel('vendor/product')
            ->setStoreId($this->getRequest()->getParam('store', 0));

        if (!$productId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
        }

        // $product->setData('_edit_mode', true);
        if ($productId) {
            try {
                $product->load($productId);
            } catch (Exception $e) {
                // $product->setTypeId(Mage_Catalog_Model_Product_Type::DEFAULT_TYPE);
                Mage::logException($e);
            }
        }

        Mage::register('product', $product);
        Mage::register('current_product', $product);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $product;
    }

	public function editAction() {

		$productId  = (int) $this->getRequest()->getParam('id');
        $product = $this->_initProduct();

        if ($productId && !$product->getId()) {
            $this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($product->getName());

		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveAction() {
		try {

			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid Request");
			}

			$id = $this->getRequest()->getParam('id');
			$data = $this->getRequest()->getPost();
			$model = Mage::getModel('vendor/product');

			foreach ($data as &$key) {
				if (is_array($key)) {
					$key = implode(',', $key);
				}
			}

			if (!$id) 
			{
				$model->setData($data);
				$model->setCreatedAt(date('Y-m-d H:i:s'));
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setVendorStatus('new');
				$model->setVendorId(Mage::helper('vendor')->_getSession()->getId());
			} 
			else 
			{	
				$model = $model->load($id);
				if (!$model->getId()) {
					throw new Exception("Invalid Product Id");
				}
				$model->addData($data);
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setVendorStatus('edit');
				
			}
			$model->save();
			Mage::helper('vendor')->_getSession()->addSuccess($this->__('Vendor Product Save Successfully'));

		} catch (Exception $e) {
			echo $e->getMessage(); die();
			Mage::getModel('vendor/session')->addError($e->getMessage());
		}
		$this->_redirect('*/*/');

	}

}

?>