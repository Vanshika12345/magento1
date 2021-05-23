<?php
class Ccc_Vendor_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	function __construct() {
		parent::__construct();
		$this->setId('vendor_product_grid');
		//$this->setUseAjax(true);
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);

	}

	protected function _getCollectionClass() {
		return 'vendor/product_collection';
	}

	protected function _getVendorName() {
		$vendors = Mage::getResourceModel('vendor/vendor_collection');
		$vendorModel = Mage::getModel('vendor/vendor');
		$vendorData = [];

		foreach ($vendors as $vendor) {
			$vendorModel->load($vendor->getEntityId());
			$vendorData[$vendorModel->getId()] = $vendorModel->getFirstname() . ' ' . $vendorModel->getLastname();
		}

		return $vendorData;
	}

	protected function _prepareCollection() {
		$collection = Mage::getResourceModel($this->_getCollectionClass())
			->addAttributeToSelect('name')
			->addAttributeToSelect('admin_status');

		$collection->joinAttribute('id', 'vendor_product/entity_id', 'entity_id', null, 'inner');
		$collection->joinAttribute('name', 'vendor_product/name', 'entity_id', null, 'inner');
		$collection->joinAttribute('price', 'vendor_product/price', 'entity_id', null, 'inner');
		$collection->joinAttribute('admin_status', 'vendor_product/admin_status', 'entity_id', null, 'left');
		$collection->joinAttribute('vendor_status', 'vendor_product/vendor_status', 'entity_id', null, 'inner');

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareMassaction() {
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('order_ids');
		$this->getMassactionBlock()->setUseSelectAll(false);

		$this->getMassactionBlock()->addItem('approve', array(
			'label' => Mage::helper('vendor')->__('Approve'),
			'url' => $this->getUrl('*/vendor_product/massApprove'),
		));

		$this->getMassactionBlock()->addItem('reject', array(
			'label' => Mage::helper('vendor')->__('Reject'),
			'url' => $this->getUrl('*/vendor_product/massReject'),
		));

		return $this;
	}

	protected function _prepareColumns() {
		$this->addColumn('entity_id',
			[
				'header' => "Product Id",
				'index' => 'entity_id',
			]
		);

		$this->addColumn('vendor_id',
			[
				'header' => "Vendor Name",
				'index' => 'vendor_id',
				'type' => 'options',
				'options' => $this->_getVendorName(),
			]
		);

		$this->addColumn('name',
			[
				'header' => 'Name',
				'index' => 'name',
			]
		);

		$this->addColumn('sku',
			[
				'header' => 'SKU',
				'index' => 'sku',
			]
		);

		$this->addColumn('type_id',
			[
				'header' => 'Type',
				'index' => 'type_id',
			]
		);

		$this->addColumn('price',
			[
				'header' => 'Price',
				'index' => 'price',
			]
		);

		$this->addColumn('vendor_status',
			[
				'header' => 'Vendor Status',
				'index' => 'vendor_status',
			]
		);

		$this->addColumn('admin_status',
			[
				'header' => 'Admin Status',
				'index' => 'admin_status',
			]
		);

		$this->addColumn('action',
			array(
				'header' => Mage::helper('vendor')->__('Action'),
				'width' => '70px',
				'type' => 'action',
				'getter' => 'getId',
				'actions' => array(
					array(
						'caption' => Mage::helper('vendor')->__('Approve'),
						'url' => array('base' => 'vendor/adminhtml_vendor_product/approve'),
						'field' => 'id',
						'data-column' => 'action',
					),
					array(
						'caption' => Mage::helper('vendor')->__('Reject'),
						'url' => array('base' => 'vendor/adminhtml_vendor_product/reject'),
						'field' => 'id',
						'data-column' => 'action',
					),
				),
				'filter' => false,
				'sortable' => false,
				'is_system' => true,
			)
		);

		return parent::_prepareColumns();
	}
}

?>