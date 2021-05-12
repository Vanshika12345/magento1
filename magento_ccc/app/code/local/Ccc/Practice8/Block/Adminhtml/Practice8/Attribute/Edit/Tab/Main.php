<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute_Edit_Tab_Main extends Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract{

	public function _prepareForm()
	{
		parent::_prepareForm();
		$attributeObject = $this->getAttributeObject();
		$form = $this->getForm();
		$fieldset = $form->getElement('base_fieldset');

		$fieldset->getElements()->searchById('attribute_code')->setData('class','validate-code-event'.$fieldset->getElements()->searchById('attribute_code')->getData('class'))->setData('note',$fieldset->getElements()->searchById('attribute_code')->getData('note').Mage::helper('practice8')->__('Do not use event for an attribute code,It is reserved for keywork'));

		$frontendInputElements = $form->getElement('frontend_input');
		$additionalTypes = [
			[
				'value' => 'price',
				'label' => Mage::helper('practice8')->__('Price')
			],
			[
				'value' => 'media_image',
				'label' => Mage::helper('practice8')->__('Media Image')
			]
		];

		if($attributeObject->getFrontendInput() == 'gallery'){
			$additionalTypes[] = [
				'value' => 'gallery',
				'label' => Mage::helper('practice8')->__('Gallery')	
			];
		}

		$response = new Varien_Object();
		$response->setTypes(array());
		$disable_fields = array();
		$hidden_fields = array();

		foreach ($response->getTypes() as $type) {
			$additionalTypes[] = $type;
			if(isset($type['hide_fields'])){
				$hidden_fields[$type['value']] = $type['hide_fields'];
			}

			if(isset($type['disable_types'])){
				$disable_fields[$type['value']] = $type['disable_types'];
			}
		}

		Mage::register('attribute_type_hidden_fields',$hidden_fields);
		Mage::register('attribute_type_disable_types',$disable_fields);
	
		$frontInputValues = array_merge($frontendInputElements->getValues(),$additionalTypes);
		$frontendInputElements->setValues($frontInputValues);

		$yesno = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();

		$scope = [
			Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_STORE => Mage::helper('practice8')->__('Store View'),
			Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_GLOBAL => Mage::helper('practice8')->__('Global View'),
			Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_WEBSITE => Mage::helper('practice8')->__('Website View')
		];
		if($attributeObject->getAttributeCode() == 'status' || $attributeObject->getAttributeCode() == 'tax_class_id'){
			unset($scope[Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_STORE]);
		}
		$fieldset->addField('is_global','select',[
			'label' => Mage::helper('practice8')->__('Scope'),
			'name' => 'is_global',
			'title' => Mage::helper('practice8')->__('Scope'),
			'mode_labels' => [
				'all' => Mage::helper('practice8')->__('All Product'),
				'custom' => Mage::helper('practice8')->__('Selected Product Types')
			],
			'values' => $scope
		],'attribute_code'); 


		$fieldset = $form->addFieldSet('front_fieldset',[
			'legend' => Mage::helper('practice8')->__('Frontend Properties'),
			'class' => 'fieldset'
		]);

		$fieldset->addField('is_searchable','select',[
			'label' => Mage::helper('practice8')->__('Use in Quick Search'),
			'name' => 'is_searchable',
			'title' => Mage::helper('practice8')->__('Use in Quick Search'),
			'values' => $yesno
		]);
		$fieldset->addField('is_filterable','select',[
			'label' => Mage::helper('practice8')->__('Use in Layered Navigation'),
			'name' => 'is_searchable',
			'title' => Mage::helper('practice8')->__('Use in Layered Navigation'),
			'values' => [
				[
					'value' => '0',
					'label' => Mage::helper('practice8')->__('No')
				],
				[
					'value' => '1',
					'label' => Mage::helper('practice8')->__('Filterable( with results)')
				],
				[
					'value' => '2',
					'label' => Mage::helper('practice8')->__('Filterable(no results)')
				],
			]
		]);
		$fieldset->addField('is_visible_in_advanced_search','select',[
		'label' => Mage::helper('practice8')->__('Use in advanced Search'),
			'name' => 'is_searchable',
			'title' => Mage::helper('practice8')->__('Use in advanced Search'),
			'values' => $yesno
		]);
		$fieldset->addField('is_comparable','select',[
		'label' => Mage::helper('practice8')->__('Comparable on Front-end'),
			'name' => 'is_searchable',
			'title' => Mage::helper('practice8')->__('Comparable on Front-end'),
			'values' => $yesno
		]);

		$fieldset->addField('is_filterable_in_search', 'select', array(
            'name' => 'is_filterable_in_search',
            'label' => Mage::helper('practice8')->__("Use In Search Results Layered Navigation"),
            'title' => Mage::helper('practice8')->__('Can be used only with practice8 input type Dropdown, Multiple Select and Price'),
            'note' => Mage::helper('practice8')->__('Can be used only with practice8 input type Dropdown, Multiple Select and Price'),
            'values' => $yesno,
        ));

        $fieldset->addField('is_used_for_promo_rules', 'select', array(
            'name' => 'is_used_for_promo_rules',
            'label' => Mage::helper('practice8')->__('Use for Promo Rule Conditions'),
            'title' => Mage::helper('practice8')->__('Use for Promo Rule Conditions'),
            'values' => $yesno,
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('practice8')->__('Position'),
            'title' => Mage::helper('practice8')->__('Position in Layered Navigation'),
            'note' => Mage::helper('practice8')->__('Position of attribute in layered navigation block'),
            'class' => 'validate-digits',
        ));


        if(!$attributeObject->getId() || $attributeObject->getIsWsyiwygEnabled()){
        	$attributeObject->setIsHtmlAllowedOnFront(1);
        }

        $fieldset->addField('is_wysiwyg_enabled', 'select', array(
            'name' => 'is_wysiwyg_enabled',
            'label' => Mage::helper('practice8')->__('Enable WYSIWYG'),
            'title' => Mage::helper('practice8')->__('Enable WYSIWYG'),
            'values' => $yesno,
        ));

        $htmlAllowed = $fieldset->addField('is_html_allowed_on_front', 'select', array(
            'name' => 'is_html_allowed_on_front',
            'label' => Mage::helper('practice8')->__('Allow HTML Tags on Frontend'),
            'title' => Mage::helper('practice8')->__('Allow HTML Tags on Frontend'),
            'values' => $yesno,
        ));

        $fieldset->addField('is_visible_on_front', 'select', array(
            'name'      => 'is_visible_on_front',
            'label'     => Mage::helper('practice8')->__('Visible on Product View Page on Front-end'),
            'title'     => Mage::helper('practice8')->__('Visible on Product View Page on Front-end'),
            'values'    => $yesno,
        ));

        $fieldset->addField('used_in_product_listing', 'select', array(
            'name'      => 'used_in_product_listing',
            'label'     => Mage::helper('practice8')->__('Used in Product Listing'),
            'title'     => Mage::helper('practice8')->__('Used in Product Listing'),
            'note'      => Mage::helper('practice8')->__('Depends on design theme'),
            'values'    => $yesno,
        ));
        $fieldset->addField('used_for_sort_by', 'select', array(
            'name'      => 'used_for_sort_by',
            'label'     => Mage::helper('practice8')->__('Used for Sorting in Product Listing'),
            'title'     => Mage::helper('practice8')->__('Used for Sorting in Product Listing'),
            'note'      => Mage::helper('practice8')->__('Depends on design theme'),
            'values'    => $yesno,
        ));

        /*$this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap("is_wysiwyg_enabled", 'wysiwyg_enabled')
            ->addFieldMap("is_html_allowed_on_front", 'html_allowed_on_front')
            ->addFieldMap("frontend_input", 'frontend_input_type')
            ->addFieldDependence('wysiwyg_enabled', 'frontend_input_type', 'textarea')
            ->addFieldDependence('html_allowed_on_front', 'wysiwyg_enabled', '0')
        );
*/
	return $this;
                
	}
}



?>