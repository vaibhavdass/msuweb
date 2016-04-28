<?php

require_once 'app/Mage.php';
Mage::app();

//$product = Mage::getModel('catalog/product')->load(24517);
//echo $product->getName();

// $incrementId = "ORDL000000011605"; //order number
// $order = Mage::getModel('sales/order')->loadByIncrementId($incrementId);


//     echo "<pre>";
//     var_dump($order->getInvoiceCollection());

// $collection = Mage::getModel('log/visitor_online')
//         ->prepare()
//         ->getCollection();
//     /* @var $collection Mage_Log_Model_Mysql4_Visitor_Online_Collection */
// $collection->addFieldToFilter('customer_id', array('notnull' => true))->addCustomerData();
?>