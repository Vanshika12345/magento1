<?php
class Ccc_Vendor_ProductController extends Mage_Core_Controller_Front_Action {

	public function preDispatch() {
		parent::preDispatch();
		if (!$this->getRequest()->isDispatched()) {
			return false;
		}

		$action = strtolower($this->getRequest()->getActionName());
		Mage::helper('vendor')->authenticate($action, $this);
	}

	public function _getSession() {
		return Mage::getSingleton('vendor/session');
	}

	public function postDispatch() {
		parent::postDispatch();
		$this->_getSession()->unsNoReferer(false);
	}

	public function gridAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function _initProduct() {
		$this->_title($this->__('Vendor'))
			->_title($this->__('Manage Products'));

		$productId = $this->getRequest()->getParam('id');
		$product = Mage::getModel('vendor/product')
			->setStoreId($this->getRequest()->getParam('store', 0));

		if (!$productId) {
			if ($setId = $this->getRequest()->getParam('set')) {
				$product->setAttributeSetId($setId);
			}

			if ($typeId = $this->getRequest()->getParam('type')) {
				$product->setTypeId($typeId);
			}
		}

		if ($productId) {
			try {
				$product->load($productId);
			} catch (Exception $e) {
				Mage::loadException($e);
			}
		}

		Mage::register('product', $product);
		Mage::register('current_product', $product);
		Mage::getSingleton('cms/wysiwyg_config')->setSessionId($this->getRequest()->getParam('store'));
		return $product;
	}

	public function editAction() {

		$productId = $this->getRequest()->getParam('id');
		$product = $this->_initProduct();

		if ($productId && !$product->getId()) {
			$this->_getSession()->addError(Mage::helper('vendor')->__('This product no longer exists'));
			$this->_redirect('*/*/grid');
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
			$sku = $data['sku'];
            $price = $data['price'];
           	$cost = $data['cost'];
           	$spprice = $data['special_price'];
            if(!$data['name']){
            	Mage::getSingleton('core/session')->addError("Please enter the product name");
                    	$this->_redirect('*/*/edit');
                        return;
            }
            if(!$sku){
            	Mage::getSingleton('core/session')->addError("Please enter the sku");
                    	$this->_redirect('*/*/edit');
                        return;
            }
            
            if($price < 0){
            	Mage::getSingleton('core/session')->addError("Please enter the price in positive integers");
                    	$this->_redirect('*/*/edit');
                        return;
            }
            if(!$price){
            	Mage::getSingleton('core/session')->addError("Please enter the Price");
                    	$this->_redirect('*/*/edit');
                        return;
            }
			$isSku = Mage::getModel('vendor/product')->getResource()->getSkuById($sku);
                
                if(!$id){
                    
                    if($isSku){
                    	Mage::getSingleton('core/session')->addError("Product SKU already exists! (SKU must be unique.)");
                    	$this->_redirect('*/*/edit');
                        return;
              
                    }
                    $existsCatalogProduct = Mage::getModel('catalog/product')->getResource()->getIdBySku($sku);
                    if ($existsCatalogProduct) {
                    	Mage::getSingleton('core/session')->addError("Product SKU already exists!");
                        return;
                    }
                }

			foreach ($data as $key) {
				if (is_array($key)) {
					$key = implode(',', $key);
				}
			}

			if (!$id) {
				$model->setData($data);
				$model->setCreatedAt(date('Y-m-d H:i:s'));
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setVendorStatus('new');
				$model->setAdminStatus('pending');
				$model->setVendorId(Mage::helper('vendor')->_getSession()->getId());
			} else {
				$model = $model->load($id);
				if (!$model->getId()) {
					throw new Exception("Invalid product Id");
				}
				$model->addData($data);
				$model->setUpdatedAt(date('Y-m-d H:i:s'));
				$model->setVendorStatus('edit');
				$model->setAdminStatus('pending');
			}
			
			$model->save();
			Mage::helper('vendor')->_getSession($this->__('Vendor Product Save Successfully'));
		} catch (Exception $e) {
			print_r($e->getMessage());
			die();
			Mage::getModel('vendor/session')->addError($e->getMessage());
		}
		$this->_redirect('*/*/grid');
	}

	public function deleteAction() {
		if ($id = $this->getRequest()->getParam('id')) {
			$model = Mage::getModel('vendor/product')->load($id);
			$model->setVendorStatus('delete');
			$model->setAdminStatus('pending');
			$model->save();

			Mage::helper('vendor')->_getSession()->addSuccess($this->__('Vendor Product Delete Successfully'));

			$this->_redirect('*/*/grid');
			return;
		}
		Mage::helper('vendor')->_getSession()->addError($this->__('Vendor Product Not Delete Successfully'));

		$this->_redirect('*/*/grid');
	}
}
?>