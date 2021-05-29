<?php 

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE {$installer->getTable('order/cart_address')} ADD firstname varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/cart_address')} ADD lastname varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/order_address')} ADD firstname varchar(64);");
$installer->run("ALTER TABLE {$installer->getTable('order/order_address')} ADD lastname varchar(64);");
$installer->endSetup();

?>