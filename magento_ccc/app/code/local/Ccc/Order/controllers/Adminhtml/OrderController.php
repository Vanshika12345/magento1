<?php

class Ccc_Order_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action{

	
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	public function customerGridAction()
	{
		$this->loadLayout();
		$this->_getSession()->setData('showGrid',0);
		$this->renderLayout();
	}

	public function viewAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveCommentAction()
	{
		$postData = $this->getRequest()->getPost('history');
		$orderId = $this->getRequest()->getParam('order_id');
		if($postData){
			$model = Mage::getModel('order/order_status')->load($orderId,'order_id');
			if($model->getId()){
				$model->addData($postData);
			} else {
				$model->setData($postData);
				$model->setOrderId($orderId);
			}
		$model->setCreatedDate(date('Y-m-d h:i:s'));
        $model->save();
        
        Mage::getSingleton('adminhtml/session')->addSuccess("Status Saved");
		}
        $this->_redirect('*/*/view',['_current'=>true]);
	}

		
}

?>