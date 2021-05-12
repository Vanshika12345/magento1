<?php

class Ccc_Practice8_Adminhtml_Practice8Controller extends Mage_Adminhtml_Controller_Action{

     protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('practice8/practice8');
    }

	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('practice8');
		$this->_addContent($this->getLayout()->createBlock('practice8/adminhtml_practice8'));
		$this->renderLayout();
	}

	public function _initPractice8()
	{
		$id = $this->getRequest()->getParam('id');
		$model = Mage::getModel('practice8/practice8')->setStoreId($this->getRequest()->getParam('store',0))->load($id);
		
		Mage::register('current_practice8',$model);
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
		return $model;		
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		$model = $this->_initPractice8();
		if($id && !$model->getId()){
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice8')->__('This practice8 no longer exists'));
			$this->_redirect('*/*/');
		}
		$this->loadLayout();
		$this->_setActiveMenu('practice8/practice8');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->renderLayout();
	}

	public function saveAction()
    {

        try {

            $practice8Data = $this->getRequest()->getPost('practice8');

            $practice8 = Mage::getSingleton('practice8/practice8');

            if ($practice8Id = $this->getRequest()->getParam('id')) {

                if (!$practice8->load($practice8Id)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

            }

            $practice8->addData($practice8Data);

            $practice8->save();

            Mage::getSingleton('core/session')->addSuccess("Practice8 data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }

    }

    public function deleteAction()
    {
        try {

            $practice8Model = Mage::getModel('practice8/practice8');

            if (!($practice8Id = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$practice8Model->load($practice8Id)) {
                throw new Exception('practice8 does not exist');
            }

            if (!$practice8Model->delete()) {
                throw new Exception('Error in delete record');
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The practice8 has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }


}

?>