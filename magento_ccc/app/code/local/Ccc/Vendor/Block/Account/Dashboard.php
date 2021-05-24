<?php

class Ccc_Vendor_Block_Account_Dashboard extends Mage_Core_Block_Template
{
    protected $_subscription = null;

    public function getVendor()
    {
        return Mage::getSingleton('vendor/session')->getVendor();
    }

    public function getAccountUrl()
    {
        return Mage::getUrl('vendor/account/edit', array('_secure'=>true));
    }

    // public function getAddressesUrl()
    // {
    //     return Mage::getUrl('vendor/address/index', array('_secure'=>true));
    // }

    // public function getAddressEditUrl($address)
    // {
    //     return Mage::getUrl('vendor/address/edit', array('_secure'=>true, 'id'=>$address->getId()));
    // }

    // public function getOrdersUrl()
    // {
    //     return Mage::getUrl('vendor/order/index', array('_secure'=>true));
    // }

    // public function getReviewsUrl()
    // {
    //     return Mage::getUrl('review/vendor/index', array('_secure'=>true));
    // }

    // public function getWishlistUrl()
    // {
    //     return Mage::getUrl('vendor/wishlist/index', array('_secure'=>true));
    // }

    // public function getTagsUrl()
    // {

    // }

    public function getSubscriptionObject()
    {
        if(is_null($this->_subscription)) {
            $this->_subscription = Mage::getModel('newsletter/subscriber')->loadByVendor($this->getVendor());
        }

        return $this->_subscription;
    }

    public function getManageNewsletterUrl()
    {
        return $this->getUrl('*/newsletter/manage');
    }

    public function getSubscriptionText()
    {
        if($this->getSubscriptionObject()->isSubscribed()) {
            return Mage::helper('vendor')->__('You are currently subscribed to our newsletter.');
        }

        return Mage::helper('vendor')->__('You are currently not subscribed to our newsletter.');
    }

    // public function getPrimaryAddresses()
    // {
    //     $addresses = $this->getvendor()->getPrimaryAddresses();
    //     if (empty($addresses)) {
    //         return false;
    //     }
    //     return $addresses;
    // }

    /**
     * Get back url in account dashboard
     *
     * This method is copypasted in:
     * Mage_Wishlist_Block_vendor_Wishlist  - because of strange inheritance
     * Mage_vendor_Block_Address_Book - because of secure url
     *
     * @return string
     */
    public function getBackUrl()
    {
        // the RefererUrl must be set in appropriate controller
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('vendor/account/');
    }
}