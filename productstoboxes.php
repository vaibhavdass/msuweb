<html>
<head>
	<style type="text/css">
		option { height: 20px; line-height: 20px; }
		body { text-align: center; }
		button { background-color: #006600; border: 0 none; color: white; cursor: pointer; font-weight: bold; height: 30px; margin-left: 10px; font-family: Segoe Print; font-size: 15px; }
		.backbutton { background-color: #006600; border: 0 none; color: white; cursor: pointer; font-weight: bold; height: 30px; margin-left: 100px; font-family: Segoe Print; font-size: 15px; padding: 1px 10px !important; text-decoration: none; }
		select { float:left;width:150px;margin-left: 10px !important; }
		tr { height: 35px !important; }
		table { font-size: 17px; text-align: center; padding-left: 42%; }
	</style>
	<script type="text/javascript">
		function validateForm() {
			var selects = document.getElementsByTagName('select');
			var count = 0;
			var arr = [];
			for(var i=0; i<selects.length; i++){
				if(selects[i].value == 0){
					selects[i].style.backgroundColor = "#F5DEB3";
					count++;
				}else{
					arr.push(selects[i].value);
					selects[i].style.backgroundColor = "#fff";
				}
			}
			if (count > 0) {
				alert("Please Select All Dropdowns");
				return false;
			}
			for (i = 1; i < selects[0].length; i++) {
				if(!isInArray(selects[0].options[i].value, arr)){
					alert('Box '+selects[0].options[i].value+' has no products');
					return false;
				}
			}
		}
		function isInArray(value, array) {
			return array.indexOf(value) > -1;
		}
	</script>
	<title>Distribute Products To The Boxes</title>
</head>
<?php 
	// echo print_r($_REQUEST);
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$invoice = Mage::getModel('sales/order_invoice')->load($_REQUEST['invoice_id']);
	$order = Mage::getModel('sales/order')->load($invoice['order_id']);
	$items = $order->getAllItems();
	$action = 'https://mysoresareeudyog.com/completepackingslip.php';
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');
	echo '<form action="'.$action.'" name="packing_slip_boxes_form" method="POST" onsubmit="return validateForm()" >';
	echo '<table><tr><th>Product SKU</th><th>Select a Box</th></tr>';
	foreach ($items as $item){
		$selectquery = 'SELECT `boxnum` FROM `packing_list_box_info` WHERE `invoice_id` = '.$_REQUEST['invoice_id'].' AND `sku` = '.$item['sku'].' limit 0,1';
		$select = $read->fetchAll($selectquery);
		// echo $select[0]['boxnum'].'<br>';
		echo '<tr>';
		echo '<td> '.$item['sku'].'</td>';
		echo '<td><select id="products_to_boxes" name="'.$item['sku'] .'" class="required-entry">
			<option value="0">--- Please Select ---</option>';
			for ($i=1; $i <= $_REQUEST['noofboxes']; $i++) { 
				if ($select[0]['boxnum'] == $i) $selected = 'selected'; else $selected = '';
				echo '<option class='.$i.' id='.$i.' name='.$i.' value='.$i.' '.$selected.'>Allotted to Box - '.$i.'</option>';
			}
		echo '</select></td>';
		echo '</tr>';
	}
	echo '</table>';
?>
<input type="hidden" name="invoice_id" value="<?php echo $_REQUEST['invoice_id']; ?>" />
<input type="hidden" name="size" value="<?php echo $_REQUEST['noofboxes']; ?>" />
<br>
<a class='backbutton' href="<?php echo $_SERVER['HTTP_REFERER']; ?>" >Back</a>
<button type="submit" > Save & Continue </button>
<?php echo '</form>'; ?>
</html>