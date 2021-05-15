<?php 

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('vendor/vendor_group'))
    ->addColumn('vendor_group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Group Id')
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Eav Group Id')
    ->addColumn('group_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Group name')
    ->addColumn('vendor_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Eav Group Id')
    ->addForeignKey($installer->getFkName('vendor/vendor_group', 'group_id', 'eav/attribute_group', 'attribute_group_id'),
        'group_id', $installer->getTable('eav/attribute_group'), 'attribute_group_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Vendor Attribute Group');
$installer->getConnection()->createTable($table);
$installer->endSetup();

?>