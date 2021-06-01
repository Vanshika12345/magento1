<?php  
class Ccc_Order_Block_Adminhtml_View extends Mage_Core_Block_Template
{
	function __construct()
	{
		parent::__construct();
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
}

?>