<?php

class Ccc_Vendor_Product_Attribute_GroupController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {
		$this->loadLayout();
		$this->_initLayoutMessages('vendor/session');
		$this->_initLayoutMessages('catalog/session');

		$this->renderLayout();
	}

	public function addAction() {
		$this->_forward('edit');
	}

	public function deleteAction() {
		try {
			$id = (int) $this->getRequest()->getParam('group_id');

			if (!$id) {
				throw new Exception("Invalid Id");
			}
			$model = Mage::getModel('eav/entity_attribute_group')->load($id);
			$model->delete();
			Mage::getSingleton('vendor/session')->addSuccess('Group Deleted Successfully');
		} catch (Exception $e) {
			Mage::getSingleton('vendor/session')->addError($e->getMessage());
		}
		$this->_redirect('*/*/');
	}

	public function editAction() {
		$id = $this->getRequest()->getParam('group_id');
		$vendor = Mage::getModel('vendor/group');
		if ($id) {
			$vendor->load($id, 'group_id');
		}
		Mage::register('group_data', $vendor);
		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveAction() {

		$data = $this->getRequest()->getPost();

		$vendorId = Mage::getSingleton('vendor/session')->getVendor()->getId();
		$data_new = $vendorId . '_' . strtolower($data['group_name']);
		$id = $this->getRequest()->getParam('group_id');
		$entityGroup = Mage::getModel('eav/entity_attribute_group');
		$vendor = Mage::getModel('vendor/group');
		$groupExist = $vendor->validateGroup($data['group_name']);
		if (!$groupExist) {
			Mage::getSingleton('core/session')->addError("Group Name Already Exist");
			if ($id) {
				$this->_redirect('vendor/product_attribute_group/add/', ['id' => $id]);
				return;
			}
			$this->_redirect('vendor/product_attribute_group/add/');
			return;
		}
		//for existing group
		if ($id) {

			$entityGroup->load($id, 'attribute_group_id');
			if (!$entityGroup) {
				Mage::getSingleton('vendor/session')->addError("Invalid Entity Group Id");
			}

			$defaultId = Mage::getSingleton('vendor/session')->getVendor()->getResource()->getEntityType()->getDefaultAttributeSetId();
			$entityGroup->setAttributeGroupName($data_new);
			$entityGroup->setAttributeSetId($defaultId);
			$entityGroup->save();

			$groupId = $entityGroup->getId();
			$vendor->load($id, 'group_id');
			$vendor->setGroupName($data['group_name']);
			$vendor->save();
			$this->_redirect('vendor/product_attribute_group/index');

		} else {
			// for new group
			$defaultId = Mage::getSingleton('eav/config')
				->getEntityType('vendor_product')
				->getDefaultAttributeSetId();
			$entityGroup->setAttributeGroupName($data_new);
			$entityGroup->setAttributeSetId($defaultId);
			$entityGroup->save();
			$groupId = $entityGroup->getId();
			if ($groupId) {

				$vendor->setGroupName($data['group_name']);
				$vendor->setGroupId($groupId);
				$vendor->setVendorId(Mage::getSingleton('vendor/session')->getVendor()->getId());
				$vendor->save();

			}

		}
		$this->_redirect('vendor/product_attribute_group/index');
	}
}

?>
