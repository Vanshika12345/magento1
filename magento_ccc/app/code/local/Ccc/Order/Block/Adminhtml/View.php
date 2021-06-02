<?php  
class Ccc_Order_Block_Adminhtml_View extends Mage_Adminhtml_Block_Template
{
	public function _construct()
	{
		$this->setTemplate('order/view.phtml');
	}

	public function setOrder(Ccc_Order_Model_Order $order)
	{
		$this->order = $order;
	}
	public function getOrder()
	{
		return $this->order;
	}

	public function getBackUrl()
	{
		return $this->getUrl('*/adminhtml_order/index');
	}
}

?>