<?php
class Ccc_Vendor_GroupController extends Mage_Core_Controller_Front_Action {

	public function gridAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function addAction() {
		$id = $this->getRequest()->getParam('id');
		if ($id) {
			$vendorGroupModel = Mage::getModel('vendor/group')->load($id, 'group_id');
			if ($vendorGroupModel->getGroupId()) {
				Mage::register('group_data', $vendorGroupModel);
			}
		}
		$this->loadLayout();
		$this->renderLayout();

	}

	public function saveAction() {
		if ($this->getRequest()->getPost()) {
			try {
				$id = $this->getRequest()->getParam('id');
				$vendor = Mage::getSingleton('vendor/session')->getId();
				$groupData = $this->getRequest()->getPost('group');

				$vendorProduct = Mage::getModel('vendor/product');
				$vendorModelGroup = Mage::getSingleton('vendor/group');

				if ($id) {
					$vendorModelGroup = Mage::getSingleton('vendor/group')->load($id, 'group_id');
					$model = Mage::getModel('eav/entity_attribute_group')->load($id, 'attribute_group_id');
					if ($groupData) {
						$groupName = strtolower($groupData['name']) . '_' . $vendor;
						$model->setAttributeGroupName($groupName)
							->setAttributeSetId($model->getAttributeSetId());
						$vendorModelGroup->setGroupName($groupData['name'])
							->setEntityId($vendorModelGroup->getEntityId());
						$model->save();
						$vendorModelGroup->save();
						Mage::getSingleton('Adminhtml/Session')->addSuccess('Vendor Group Updated Successfully');

					}
					$this->_redirect('vendor/group/grid');
				}

				$vendorGroupFilter = $vendorModelGroup->getCollection()->addFieldToFilter('entity_id', $vendor);
				$vendorGroupNameFilter = $vendorGroupFilter->addFieldToFilter('group_name', $groupData['name'])->getData();

				if ($vendorGroupNameFilter) {
					Mage::getSingleton('core/session')->addError('A group with the same name already Existed');
					$this->_redirect('vendor/group/add');
					return;
				}

				$attributeSetId = $vendorProduct->getResource()->getEntityType()->getDefaultAttributeSetId();
				$groupName = strtolower($groupData['name']) . '_' . $vendor;

				$model = Mage::getModel('eav/entity_attribute_group');
				$model->setAttributeGroupName($groupName)
					->setAttributeSetId($attributeSetId);

				$model->save();

				$GroupId = $model->getId();

				if ($GroupId) {
					$vendorModelGroup->setGroupId($GroupId)
						->setEntityId($vendor)
						->setGroupName($groupData['name']);

					$vendorModelGroup->save();
					Mage::getSingleton('core/session')->addSuccess('Vendor Group Add Successfully');
				}

				$this->_redirect('vendor/group/grid');
			} catch (Exception $e) {
				Mage::getSingleton('core/session')->addError('Error while saving the group');
			}

		}
	}

	public function deleteAction() {
		try {
			$groupId = $this->getRequest()->getParam("id");
			if (!$groupId) {
				throw new Exception("Invalid Id.");
			}
			$model = Mage::getModel("eav/entity_attribute_group")->load($groupId);
			$model->delete();
			Mage::getSingleton("vendor/session")->addSuccess("Group Deleted Successfully");
		} catch (Exception $e) {
			Mage::getSingleton("vendor/session")->addError($e->getMessage());
		}
		$this->_redirect("*/*/grid");
	}
}

?>