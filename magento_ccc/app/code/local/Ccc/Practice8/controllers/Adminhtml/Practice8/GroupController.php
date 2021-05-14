<?php

class Ccc_Practice8_Adminhtml_Practice8_GroupController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('practice8/practice8');
    }
    
    public function saveAction()
    {
        $model = Mage::getModel('eav/entity_attribute_group');

        $model->setAttributeGroupName($this->getRequest()->getParam('attribute_group_name'))
              ->setAttributeSetId($this->getRequest()->getParam('attribute_set_id'));

        if( $model->itemExists() ) {
            Mage::getSingleton('practice8/session')->addError(Mage::helper('practice8')->__('A group with the same name already exists.'));
        } else {
            try {
                $model->save();
            } catch (Exception $e) {
                Mage::getSingleton('practice8/session')->addError(Mage::helper('practice8')->__('An error occurred while saving this group.'));
            }
        }
    }

}