<?php


$installer = $this;
$installer->run(" DROP TABLE IF EXISTS `{$installer->getTable('order/cart')}`;
	DROP TABLE IF EXISTS `{$installer->getTable('order/cart_item')}`;
	DROP TABLE IF EXISTS `{$installer->getTable('order/cart_address')}`;
	DROP TABLE IF EXISTS `{$installer->getTable('order/order_address')}`;
	DROP TABLE IF EXISTS `{$installer->getTable('order/order_item')}`;
	DROP TABLE IF EXISTS `{$installer->getTable('order/order')}`;");
$table = $installer->getConnection()->newTable($installer->getTable('order/cart'))
	->addColumn('cart_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'primary' => true,
		'identity' => true,
		'nullable' =>false
	],'cartId')
	->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'nullable' => false
	],'customerId')
	->addColumn('session_id',Varien_Db_Ddl_Table::TYPE_VARCHAR,50,[
		'nullable' => true
	],'sessionId')
	->addColumn('total',Varien_Db_Ddl_Table::TYPE_DECIMAL,'10,2',[
		'nullable' => false
	],'total')
	->addColumn('discount',Varien_Db_Ddl_Table::TYPE_DECIMAL,'10,2',[
		'nullable' => true
	],'discount')
	->addColumn('payment_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,[
		'nullable' => false
	],'payment_code')
	->addColumn('shipment_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,[
		'nullable' => false
	],'shipment_code')
	->addColumn('shipping_amount',Varien_Db_Ddl_Table::TYPE_DECIMAL,'10,2',[
		'nullable' => false
	],'shipping_amount')
	->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null,[
		'nullable' => false,
	],'created_at')
	->addForeignKey($installer->getFkName('cart','customer_id','customer_entity','entity_id'),'customer_id','customer_entity','entity_id',Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE);

$installer->getConnection()->createTable($table);
$installer->endSetup();	
?>