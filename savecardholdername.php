<?php //print_r($_REQUEST);
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$write = Mage::getSingleton('core/resource')->getConnection('core_write');
	// print_r($_REQUEST);
	$query = "INSERT INTO `invoice_cardholders_list` (`name`, `invoice`, `created_time`, `update_time`) VALUES ('".$_REQUEST['name']."', '".$_REQUEST['invoice']."', '".now()."', '".now()."')";
	$check = $write->query($query);
	return ;
?>