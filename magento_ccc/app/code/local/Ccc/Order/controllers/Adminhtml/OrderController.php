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


		
}

?>