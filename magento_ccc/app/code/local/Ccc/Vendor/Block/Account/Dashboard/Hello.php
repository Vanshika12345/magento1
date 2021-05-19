<?php 
class Ccc_Vendor_Block_Account_Dashboard_Hello extends Mage_Core_Block_Template
{

    public function getVendorName()
    {
    	$session =  Mage::getSingleton('vendor/session');
    	$firstName = $session->getVendor()->getFirstname();
    	$lastname = $session->getVendor()->getLastname();
    	return $firstName.' '.$lastname;
    	
    }

}

?>
