<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Enter No.of Boxes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
	#Table_01 td,#Table_01 th  { border-right:1px solid #000;border-bottom:1px solid #000; }
	input { height: 20px; width: 160px; }
	button { background-color: #006600; border: 0 none; color: white; cursor: pointer; font-weight: bold; height: 30px; font-family: Segoe Print; font-size: 15px; }
	body { text-align: center; padding: 50px ! important;font-size: 20px !important; }
</style>
<script type="text/javascript">
	function validateForm() {
	    var values = document.forms["packing_slip_form"]["noofboxes"].value;
	    if (values == null || values == "") {
	        alert("Please Enter no.of Boxes");
	        return false;
	    }
	}
</script>
</head>
<body bgcolor="#FFFFFF">
<?php
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$invoice = Mage::getModel('sales/order_invoice')->load($_GET['id']);
	$order = Mage::getModel('sales/order')->load($invoice['order_id']);
	$items = $order->getAllItems();
	// $action = Mage::getBaseUrl().'productstoboxes.php';
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');
	$selectquery = 'SELECT `boxes_size` FROM `packing_list_box_info` WHERE `invoice_id` = '.$_GET['id'].' limit 0,1';
	$select = $read->fetchAll($selectquery);
?>
<form action="<?php echo 'https://www.mysoresareeudyog.com/productstoboxes.php'; ?>" name="packing_slip_form" method="POST" onsubmit="return validateForm()" >
	<input type="hidden" name="invoice_id" value="<?php echo $_GET['id']; ?>" />
	Enter No.of Boxes : <input type="text" name="noofboxes" value="<?php echo $select[0]['boxes_size']; ?>" /> <button type="submit">Submit</button>
</form>
</body>
</html>