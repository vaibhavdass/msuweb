<?php

$id = $_REQUEST['id'];

//$proxy = new SoapClient('http://mysoresa.thedemolabs.com/api/v2_soap/?wsdl=1');
$proxy = new SoapClient('https://www.mysoresareeudyog.com/api/v2_soap/?wsdl=1');
//$proxy = new SoapClient('http://mysoresa.nextmp.net/api/soap/?wsdl');
$sessionId = $proxy->login('maitri', 'N@resh8055');

//$result = $proxy->salesOrderInfo($sessionId, $id);
$result = $proxy->salesOrderInvoiceInfo($sessionId, $id);
//$result = $proxy->call($sessionId, 'product_stock.update', array('2259922', array('qty'=>50, 'is_in_stock'=>1, 'is_in_stock'=>1)));
//var_dump($proxy->call($sessionId, 'product_stock.list', '2259922'));

//$result = $proxy->catalogInventoryStockItemUpdate($sessionId, '2259922', array('qty'=>52, 'is_in_stock'=>1, 'min_qty'=>1,'backorders'=>0, 'use_config_backorders'=>0));
//$result = $proxy->catalogInventoryStockItemUpdate($sessionId, '2349954', array('manage_stock'=>1,'backorders'=>1, 'use_config_backorders'=>0,'qty'=>52, 'is_in_stock'=>1));
//$result = $proxy->catalogProductUpdate($sessionId, '2349954', array( 'status' => '2','stock_data'=>array('qty'=>52, 'is_in_stock'=>1)));


var_dump ($result);
echo "1";
//$result = $proxy->salesOrderInfo($sessionId, $id);
//var_dump($result);

// Version 1
/*
	$client = new SoapClient('http://mysoresa.nextmp.net/api/soap/?wsdl');
$session = $client->login('kushal', '1111111111');
$result = $client->call($sessionId, 'sales_order.info', $id);
var_dump($result);

*/

?>