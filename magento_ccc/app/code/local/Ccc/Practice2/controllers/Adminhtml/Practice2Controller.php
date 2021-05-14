<?php

class Ccc_Practice2_Adminhtml_Practice2Controller extends Mage_Adminhtml_Controller_Action{

	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}	

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		$practice2Model = Mage::getModel('practice2/practice2')->load($id);
		if($practice2Model->getId()){
			Mage::register('practice2_data',$practice2Model);
		}
		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveAction()
	{
		try{
			$id = $this->getRequest()->getParam('id');
			$practice2Model = Mage::getModel('practice2/practice2')->load($id);
			$practice2Data = $this->getRequest()->getPost('practice2');
			if($practice2Model->getId()){
				$practice2Model->setData($practice2Data);
				$practice2Model->setId($id);
				Mage::getSingleton('Admin/Session')->addSuccess('Updated Successfully');
			} else {
				$practice2Model->setData($practice2Data);
				$practice2Model->setData('createdAt',date('Y-m-d H:i:s'));
				Mage::getSingleton('Admin/Session')->addSuccess('Inserted Successfully');
			}

			$practice2Model->save();
			$this->_redirect('*/*/');
		} catch(Exception $e) {

		}

	}

	public function deleteAction()
	{
		try{
			$id = $this->getRequest()->getParam('id');
			$practice2Model = Mage::getModel('practice2/practice2')->load($id)->delete();
			Mage::getSingleton('Admin/Session')->addSuccess('Deleted Successfully');
			$this->_redirect('*/*/');
		} catch(Exception $e) {

		}	
	}
}


?>