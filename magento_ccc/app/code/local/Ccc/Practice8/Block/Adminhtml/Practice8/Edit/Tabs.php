<?php


class Ccc_Practice8_Block_Adminhtml_Practice8_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{

	public function __construct()
	{
		parent::__construct();
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('practice8')->__('Practice8 Information'));
	}

	public function getPractice8()
	{
		return Mage::registry('current_practice8');
	}

	public function _beforeToHtml()
	{
		$practice8Attributes = Mage::getResourceModel('practice8/practice8_attribute_collection');

		if(!$this->getPractice8()->getId()){
			foreach ($practice8Attributes as $attribute) {
				$defaultValue = $attribute->getDefaultValue();
				if($defaultValue != ''){
					$this->getPractice8()->setData($attribute->getAttributeCode(),$defaultValue);
				}
			}
		}

		$attributeSetId = $this->getPractice8()->getResource()->getEntityType()->getDefaultAttributeSetId();



        // $attributeSetId = 21;
        
        $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->setSortOrder()
            ->load();

		//setting default group Id
		$defaultGroupId = 0;
		foreach ($groupCollection as $group) {
			if($defaultGroupId == 0 || $group->getIsDefault()){
				$defaultGroupId = $group->getId();
			}
		}

		//storing attributes based on group,setId
		foreach ($groupCollection as $group) {
			$attributes = array();
			foreach ($practice8Attributes as $attribute) {
				if($this->getPractice8()->checkInGroup($attribute->getId(),$attributeSetId,$group->getId())){
					$attributes[] = $attribute;
				}
				
			}

			if(!$attributes){
				continue;
			}

			$active = $defaultGroupId == $group->getId();
			$block = $this->getLayout()->createBlock('practice8/adminhtml_practice8_edit_tab_attributes')->setGroup($group)->setAttributes($attributes)->setAddHiddenFields($active)->toHtml();

			$this->addTab('group_'.$group->getId(),array('label' => Mage::helper('practice8')->__($group->getAttributeGroupName()),
				'content' => $block,
				'active' => $active
			));

		}

		return parent::_beforeToHtml();
	}
}


?>