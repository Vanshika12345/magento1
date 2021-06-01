<?php 

class Ccc_Order_Block_Adminhtml_Address extends Mage_Core_Block_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/address.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}

	public function getOrderShippingAddress()
	{
		return $this->getOrder()->getOrderShippingAddress();
	}

	public function getOrderBillingAddress()
	{
		return $this->getOrder()->getOrderBillingAddress();
		
	}

	public function getCountryName()
	{
		  $countryCollection = Mage::getModel('directory/country_api')->items();
          
          return $countryCollection;
        
      	// $countryName = $countryModel->getName();
		// return $countryName;
	}
	
}

/**/

?>