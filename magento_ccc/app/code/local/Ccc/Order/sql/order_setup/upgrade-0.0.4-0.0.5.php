<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
	->newTable($installer->getTable('order/order_item'))
	->addColumn('order_item_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'identity' => true,
			'primary' => true,
			'nullable' => false,
		], 'Order Item Id'
	)
	->addColumn('order_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'nullable' => false,
		], 'Order Id'
	)
	->addColumn('product_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Product Id'
	)
	->addColumn('quantity',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Quantity'
	)
	->addColumn('price',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => false,
		], 'Price'
	)
	->addColumn('discount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => true,
		], 'Discount'
	)
	->addColumn('created_at',
		Varien_Db_Ddl_Table::TYPE_DATETIME, null, [
			'nullable' => true,
		]
	);
$installer->getConnection()->createTable($table);
$installer->endSetup();
?>