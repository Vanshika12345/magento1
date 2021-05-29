<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Address extends Mage_Adminhtml_Block_Template
{
	protected $cart;
	public function _construct()
	{
		$this->setTemplate('order/cart/index/address.phtml');
	}

	public function setCart(Ccc_Order_Model_Order_Cart $cart)
	{
		$this->cart = $cart;
		return $this;
	}
	public function getCart()
	{
		return $this->cart;
	}

	public function getCartShippingAddress()
	{
		$address = $this->getCart()->getCartShippingAddress();
		//print_r($address);
		if($address->getId()){
			return $address;
		}
		$customerAddress = $this->getCart()->getCustomer()->getShippingAddress();
		if($customerAddress === null){
			return $address;
		}
		return $customerAddress;
	}

	public function getCartBillingAddress() {
		
		$address = $this->getCart()->getCartBillingAddress();
		if($address->getId()){
			return $address;
		}
		$customerAddress = $this->getCart()->getCustomer()->getBillingAddress();
		if($customerAddress === null){
			return $address;
		}
		return $customerAddress;
	}

	public function getValue($address, $value){
        if(array_key_exists($value,$address)){
            return $address[$value];
        }
        return false;
    }

    public function getSaveBillingUrl(){
        return $this->getUrl('*/*/updateAddress',array('type' => 'billing','_current'=>true));
    }

	 public function getShippingAddressUrl(){
        return $this->getUrl('*/*/updateAddress',array('type' => 'shipping','_current'=>true));
    }


    public function getCountryOptions(){
        return Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
    }

	
}


?>