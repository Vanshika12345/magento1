<?php 

class Ccc_Practice2_Block_Adminhtml_Practice2_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{

	public function _prepareForm()
	{
		$form = new Varien_Data_Form(['id' => 'edit_form','action'=> $this->getUrl('*/*/save',['id' => $this->getRequest()->getParam('id')]),'method' => 'post']);

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldSet('display',[
			'legend' => 'Practice2 Information',
			'class' => 'fieldset'
		]);

		$fieldset->addField('title','text',[
			'name' => 'practice2[title]',
			'label' => 'Title',
			'required' => true
		]);

		if(Mage::registry('practice2_data')){
			$form->setValues(Mage::registry('practice2_data')->getData());
		}

		return parent::_prepareForm();
	}
}
?>