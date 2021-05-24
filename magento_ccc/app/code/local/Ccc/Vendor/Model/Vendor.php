<?php
class Ccc_Vendor_Model_Vendor extends Mage_Core_Model_Abstract
{

    const ENTITY = 'vendor';

const XML_PATH_REGISTER_EMAIL_TEMPLATE = 'vendor/create_account/email_template';
const XML_PATH_REGISTER_EMAIL_IDENTITY = 'vendor/create_account/email_identity';
const XML_PATH_REMIND_EMAIL_TEMPLATE = 'vendor/password/remind_email_template';
const XML_PATH_FORGOT_EMAIL_TEMPLATE = 'vendor/password/forgot_email_template';
const XML_PATH_FORGOT_EMAIL_IDENTITY = 'vendor/password/forgot_email_identity';
const XML_PATH_DEFAULT_EMAIL_DOMAIN = 'vendor/create_account/email_domain';
const XML_PATH_IS_CONFIRM = 'vendor/create_account/confirm';
const XML_PATH_CONFIRM_EMAIL_TEMPLATE = 'vendor/create_account/email_confirmation_template';
const XML_PATH_CONFIRMED_EMAIL_TEMPLATE = 'vendor/create_account/email_confirmed_template';
const XML_PATH_GENERATE_HUMAN_FRIENDLY_ID = 'vendor/create_account/generate_human_friendly_id';
const XML_PATH_CHANGED_PASSWORD_OR_EMAIL_TEMPLATE = 'vendor/changed_account/password_or_email_template';
const XML_PATH_CHANGED_PASSWORD_OR_EMAIL_IDENTITY = 'vendor/changed_account/password_or_email_identity';

const EXCEPTION_EMAIL_NOT_CONFIRMED = 1;
const EXCEPTION_INVALID_EMAIL_OR_PASSWORD = 2;
const EXCEPTION_INVALID_RESET_PASSWORD_LINK_TOKEN = 4;
const EXCEPTION_EMAIL_EXISTS = 3;

const SUBSCRIBED_YES = 'yes';
const SUBSCRIBED_NO = 'no';

const CACHE_TAG = 'vendor';

const MINIMUM_PASSWORD_LENGTH = 6;

     private static $_isConfirmationRequired;

    protected function _construct()
    {
        parent::_construct();
        $this->_init('vendor/vendor');

    }

    protected $_attributes;

    public function getAttributes()
    {

        if ($this->_attributes === null) {
            $this->_attributes = $this->_getResource()
                ->loadAllAttributes($this)
                ->getSortedAttributes();
        }
        return $this->_attributes;
    }

    public function checkInGroup($attributeId, $setId, $groupId)
    {
        $resource = Mage::getSingleton('core/resource');

        $readConnection = $resource->getConnection('core_read');
        $readConnection = $resource->getConnection('core_read');

        $query = '
            SELECT * FROM ' .
        $resource->getTableName('eav/entity_attribute')
            . ' WHERE `attribute_id` =' . $attributeId
            . ' AND `attribute_group_id` =' . $groupId
            . ' AND `attribute_set_id` =' . $setId
        ;

        $results = $readConnection->fetchRow($query);

        if ($results) {
            return true;
        }
        return false;
    }

     public function setStore(Mage_Core_Model_Store $store)
    {
        $this->setStoreId($store->getId());
        $this->setWebsiteId($store->getWebsite()->getId());
        return $this;
    }

    public function loadByEmail($vendorEmail)
    {
        $this->_getResource()->loadByEmail($this, $vendorEmail);
        return $this;
    }

     public function validate()
    {
        $errors = array();
        if (!Zend_Validate::is( trim($this->getFirstname()) , 'NotEmpty')) {
            $errors[] = Mage::helper('vendor')->__('The first name cannot be empty.');
        }

        if (!Zend_Validate::is( trim($this->getLastname()) , 'NotEmpty')) {
            $errors[] = Mage::helper('vendor')->__('The last name cannot be empty.');
        }

        if (!Zend_Validate::is($this->getEmail(), 'EmailAddress')) {
            $errors[] = Mage::helper('vendor')->__('Invalid email address "%s".', $this->getEmail());
        }

        $password = $this->getPassword();
        if (!$this->getId() && !Zend_Validate::is($password , 'NotEmpty')) {
            $errors[] = Mage::helper('vendor')->__('The password cannot be empty.');
        }
        if (strlen($password) && !Zend_Validate::is($password, 'StringLength', array(self::MINIMUM_PASSWORD_LENGTH))) {
            $errors[] = Mage::helper('vendor')
                ->__('The minimum password length is %s', self::MINIMUM_PASSWORD_LENGTH);
        }
        $confirmation = $this->getPasswordConfirmation();
        if ($password != $confirmation) {
            $errors[] = Mage::helper('vendor')->__('Please make sure your passwords match.');
        }


        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

     public function cleanPasswordsValidationData()
    {
        $this->setData('password', null);
        $this->setData('password_confirmation', null);
        return $this;
    }

    public function isConfirmationRequired()
    {
        if ($this->canSkipConfirmation()) {
            return false;
        }
        if (self::$_isConfirmationRequired === null) {
            $storeId = $this->getStoreId() ? $this->getStoreId() : null;
            self::$_isConfirmationRequired = (bool)Mage::getStoreConfig(self::XML_PATH_IS_CONFIRM, $storeId);
        }

        return self::$_isConfirmationRequired;
    }

     public function canSkipConfirmation()
    {
        return $this->getId() && $this->hasSkipConfirmationIfEmail()
            && strtolower($this->getSkipConfirmationIfEmail()) === strtolower($this->getEmail());
    }

     public function changePassword($newPassword)
    {
        $this->_getResource()->changePassword($this, $newPassword);
        return $this;
    }

    public function setPassword($password)
    {
        $this->setData('password', $password);
        $this->setPasswordHash($this->hashPassword($password));
        $this->setPasswordConfirmation(null);
        return $this;
    }

     public function hashPassword($password, $salt = null)
    {
        return $this->_getHelper('core')
            ->getHash(trim($password), !is_null($salt) ? $salt : Mage_Admin_Model_User::HASH_SALT_LENGTH);
    }

     public function generatePassword($length = 8)
    {
        $chars = Mage_Core_Helper_Data::CHARS_PASSWORD_LOWERS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_UPPERS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_DIGITS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_SPECIALS;
        return Mage::helper('core')->getRandomString($length, $chars);
    }

    public function validatePassword($password)
    {
        $hash = $this->getPasswordHash();
        if (!$hash) {
            return false;
        }
        return Mage::helper('core')->validateHash($password, $hash);
    }

     public function encryptPassword($password)
    {
        return Mage::helper('core')->encrypt($password);
    }

     public function decryptPassword($password)
    {
        return Mage::helper('core')->decrypt($password);
    }

    protected function _getHelper($helperName)
    {
        return Mage::helper($helperName);
    }

    public function authenticate($login, $password)
    {
        $this->loadByEmail($login);
        if ($this->getConfirmation() && $this->isConfirmationRequired()) {
            throw Mage::exception('Mage_Core', Mage::helper('vendor')->__('This account is not confirmed.'),
                self::EXCEPTION_EMAIL_NOT_CONFIRMED
            );
        }
        if (!$this->validatePassword($password)) {
            throw Mage::exception('Mage_Core', Mage::helper('vendor')->__('Invalid login or password.'),
                self::EXCEPTION_INVALID_EMAIL_OR_PASSWORD
            );
        }
        Mage::dispatchEvent('vendor_vendor_authenticated', array(
           'model'    => $this,
           'password' => $password,
        ));

        return true;
    }




}