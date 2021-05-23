<?php 
class Ccc_Vendor_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract{

	protected function _construct(){
		$this->_init('vendor/vendor_group','vendor_group_id');
	}
}
?>