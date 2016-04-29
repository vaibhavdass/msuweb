<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('sales/order_grid'),'tfm_shipment_status', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'comment'   => 'Pay with Amazon tfm_shipment_status'
        )); 

$installer->endSetup();
?>

