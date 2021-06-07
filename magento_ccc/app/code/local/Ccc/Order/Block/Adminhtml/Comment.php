<?php 

class Ccc_Order_Block_Adminhtml_Comment extends Mage_Core_Block_Template
{
	protected $status = [
        'Placed'=>'1',
        'Pending'=>'2',
        'Hold'=>'2',
        'Success'=>'3',
        'Failed'=>'3'
    ];

	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/comment.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}

	public function getCommentUrl()
	{
		return $this->getUrl('*/*/saveComment',array('_current'=>true));
	}

	public function getStatuses()
	{
		return $this->status;
	}
	
}


?>