<?php

$installer = $this;
$installer->startSetup();

$installer->addForeignKey($installer->getFkName('cart','customer_id','customer_entity','entity_id'),'customer_id','customer_entity','entity_id',Varein_Ddl_Db_Table::ACTION_CASCADE,Varein_Ddl_Db_Table::ACTION_CASCADE);
$installer->endSetup();	

$installer->addForeignKey($installer->getFkName('order','customer_id','customer_entity','entity_id'),'customer_id','customer_entity','entity_id',Varein_Ddl_Db_Table::ACTION_CASCADE,Varein_Ddl_Db_Table::ACTION_CASCADE);
$installer->endSetup();	

?>