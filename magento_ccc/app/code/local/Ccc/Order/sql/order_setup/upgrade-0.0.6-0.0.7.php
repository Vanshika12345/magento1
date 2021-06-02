<?php
$installer = $this;
$installer->startSetup();
$installer->run(" 
	DROP TABLE IF EXISTS `{$installer->getTable('order/order')}`;
	TRUNCATE TABLE  `{$installer->getTable('order/order_item')}`;
	TRUNCATE TABLE  `{$installer->getTable('order/order_address')}`;

	");

$table = $installer->getConnection()
	->newTable($installer->getTable('order/order'))
	->addColumn('order_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'identity' => true,
			'nullable' => false,
			'primary' => true,
		], 'Order Id'
	)
	->addColumn('customer_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Customer Id'
	)
	->addColumn('billing_name',
		Varien_Db_Ddl_Table::TYPE_TEXT, null, [
			'nullable' => false,
		], 'biling Name')
	->addColumn('shipping_name',
		Varien_Db_Ddl_Table::TYPE_TEXT, null, [
			'nullable' => false,
		], 'Shipping Name')
	->addColumn('discount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, '10,2', [
			'nullable' => true,
		], 'Discount'
	)
	->addColumn('base_total',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, '10,2', [
			'nullable' => false,
		], 'Base Total'
	)
	->addColumn('total',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, '10,2', [
			'nullable' => false,
		], 'Total'
	)
	->addColumn('payment_code',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
			'nullable' => false,
		], 'Payment Method Code'
	)
	->addColumn('shipment_code',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
			'nullable' => false,
		], 'Shipment Method Code'
	)
	->addColumn('shipping_amount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, '10,2', [
			'nullable' => false,
		], 'Shipping Amount'
	)
	->addColumn('created_at',
		Varien_Db_Ddl_Table::TYPE_DATETIME, null, [
			'nullable' => true,
		]
	)
	->addForeignKey($installer->getFkName('order','customer_id','customer_entity','entity_id'),'customer_id','customer_entity','entity_id',Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE);

$installer->getConnection()->createTable($table);
$installer->endSetup();

?>
?>