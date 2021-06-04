<?php 
class Ccc_Vendor_Block_Group_Form extends Mage_Core_Block_Template{

	public function getGroup(){
		return Mage::getSingleton('vendor/session');
	}

	public function getGroupData(){
		return Mage::registry("group_data");
	}
	
	public function getBackUrl(){
		return $this->getUrl('vendor/account/');
	}

	public function getPostActionUrl()
    {
        return $this->helper('vendor')->getGroupPostUrl();
    }
}
?>