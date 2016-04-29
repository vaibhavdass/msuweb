<?php

$proxy = new SoapClient('https://www.mysoresareeudyog.com/api/v2_soap/?wsdl',array('cache_wsdl' => WSDL_CACHE_NONE)); // TODO : change url
$sessionId = $proxy->login('vaibhav', 'rupesh'); // TODO : change login and pwd if necessary

$result = $proxy->salesOrderInfo($sessionId, 'ORDL000000012124');
echo "<pre>";
var_dump($result);

?>