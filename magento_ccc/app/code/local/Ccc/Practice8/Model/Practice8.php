<?php

class Ccc_Practice8_Model_Practice8 extends Mage_Core_Model_Abstract{

	const ENTITY = 'practice8';
	protected $_attributes;
	
	protected function _construct(){
		$this->_init('practice8/practice8');
	}

	public function getAttributes()
	{
		if($this->_attributes === null){
			$this->_attributes = $this->_getResource()->loadAllAttributes($this)->getSortedAttributes();
		}
		return $this->_attributes;
	}

	public function checkInGroup($attributeId,$setId,$groupId)
	{
		$resource = Mage::getSingleton('core/resource');

		$query = "SELECT * FROM ". $resource->getTableName('eav/entity_attribute')." WHERE `attribute_id` = ".$attributeId." AND `attribute_group_id` =".$groupId." AND attribute_set_id = ".$setId;
		$readConnection = $resource->getConnection('core_read');
		$result = $readConnection->fetchRow($query);
		if($result){
			return true;
		}
		return false;
	}
}


?>