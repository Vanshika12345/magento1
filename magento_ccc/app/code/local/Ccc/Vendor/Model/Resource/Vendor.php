<?php
class Ccc_Vendor_Model_Resource_Vendor extends Mage_Eav_Model_Entity_Abstract
{

    const ENTITY = 'vendor';
    
    public function __construct()
    {

        $this->setType(self::ENTITY)
             ->setConnection('core_read', 'core_write');

       parent::__construct();
    }

    public function loadByEmail(Ccc_Vendor_Model_Vendor $vendor, $email, $testOnly = false)
    {
        $adapter = $this->_getReadAdapter();
        $bind    = array('vendor_email' => $email);
        $select  = $adapter->select()
            ->from($this->getEntityTable().'_varchar', array($this->getEntityIdField()))
            ->where('value = :vendor_email');

        /*if ($vendor->getSharingConfig()->isWebsiteScope()) {
            if (!$vendor->hasData('website_id')) {
                Mage::throwException(
                    Mage::helper('vendor')->__('Customer website ID must be specified when using the website scope')
                );
            }
            $bind['website_id'] = (int)$vendor->getWebsiteId();
            $select->where('website_id = :website_id');
        }*/

        $vendorId = $adapter->fetchOne($select, $bind);
        if ($vendorId) {
            $this->load($vendor, $vendorId);
        } else {
            $vendor->setData(array());
        }

        return $this;
    }

    /**
     * Change customer password
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param string $newPassword
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function changePassword(Ccc_Vendor_Model_Vendor $vendor, $newPassword)
    {
        $vendor->setPassword($newPassword);
        $this->saveAttribute($vendor, 'password_hash');
        return $this;
    }

    
    /**
     * Check customer by id
     *
     * @param int $customerId
     * @return bool
     */
    public function checkVendorId($vendorId)
    {
        $adapter = $this->_getReadAdapter();
        $bind    = array('entity_id' => (int)$vendorId);
        $select  = $adapter->select()
            ->from($this->getTable('vendor/vendor'), 'entity_id')
            ->where('entity_id = :entity_id')
            ->limit(1);

        $result = $adapter->fetchOne($select, $bind);
        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * Get customer website id
     *
     * @param int $customerId
     * @return int
     */
    public function getWebsiteId($vendorId)
    {
        $adapter = $this->_getReadAdapter();
        $bind    = array('entity_id' => (int)$vendorId);
        $select  = $adapter->select()
            ->from($this->getTable('vendor/vendor'), 'website_id')
            ->where('entity_id = :entity_id');

        return $adapter->fetchOne($select, $bind);
    }

    /**
     * Custom setter of increment ID if its needed
     *
     * @param Varien_Object $object
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function setNewIncrementId(Varien_Object $object)
    {
        if (Mage::getStoreConfig(Ccc_Vendor_Model_Vendor::XML_PATH_GENERATE_HUMAN_FRIENDLY_ID)) {
            parent::setNewIncrementId($object);
        }
        return $this;
    }

    /**
     * Change reset password link token
     *
     * Stores new reset password link token and its creation time
     *
     * @param Mage_Customer_Model_Customer $newResetPasswordLinkToken
     * @param string $newResetPasswordLinkToken
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function changeResetPasswordLinkToken(Ccc_Vendor_Model_Vendor $vendor, $newResetPasswordLinkToken) {
        if (is_string($newResetPasswordLinkToken) && !empty($newResetPasswordLinkToken)) {
            $vendor->setRpToken($newResetPasswordLinkToken);
            $currentDate = Varien_Date::now();
            $vendor->setRpTokenCreatedAt($currentDate);
            $this->saveAttribute($vendor, 'rp_token');
            $this->saveAttribute($vendor, 'rp_token_created_at');
        }
        return $this;
    }

}