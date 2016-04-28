<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Accounts Packing Slip</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
#Table_01 td,#Table_01 th  { border-right:1px solid #000;border-bottom:1px solid #000; }
</style>
</head>
<body bgcolor="#FFFFFF">
<div  style="width: 766px;">
<?php
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$invoice = Mage::getModel('sales/order_invoice')->load($_GET['id']);
	$invoicecurrencycode = $invoice['order_currency_code'];
	$invoiceno = $invoice['increment_id'];
	$invoicedate = $invoice['created_at'];
	$invoicecurrencycode = $invoice['order_currency_code'];
	$date_string = $invoicedate;
	$base = Mage::app()->getStore()->getBaseCurrencyCode();//indian
	$curr = Mage::app()->getStore()->getCurrentCurrencyCode(); //current
	$date = strtotime($date_string);
	$invoicedaten = date('d/m/y', $date);
	$order_id = $invoice['order_id'];
	$order = Mage::getModel('sales/order')->load($order_id);
	$payment = $order->getPayment();
	$tran = $payment->getLastTransId();
	$orderdate = $order['created_at'];
	$orderno = $order['increment_id']; 
	$date_string1 = $orderdate;
	$date = strtotime($date_string1);
	$i = 0;
	$shipping = $order->getShippingAddress()->getData();
	$cusnameship = $shipping['firstname']." ".$shipping['lastname'];
	$companyship = $shipping['company']; 
	$streetship = $shipping['street'];
	$regionship = $shipping['city'].", ".$shipping['region'].", ".$shipping['postcode'];
	$countryship = $shipping['country_id'];
	$telephoneship = $shipping['telephone'];
	$billing = $order->getBillingAddress()->getData();
	$cusnamebilll = $billing['firstname']." ".$billing['lastname'];
	$companybilll = $billing['company']; 
	$streetbilll = $billing['street'];
	$regionbilll = $billing['city'].", ".$billing['region'].", ".$billing['postcode'];
	$countrybilll = $billing['country_id'];
	$telephonebilll = $billing['telephone'];
	$items = $order->getAllItems();
	$currencySymbol = Mage::app()->getLocale()->currency($order['order_currency_code'])->getSymbol();
	$basecurrencySymbol = Mage::app()->getLocale()->currency($order['store_currency_code'])->getSymbol();
?>
<table id="Table_01" width="766" border="0" cellpadding="10px" cellspacing="0" style="font-size:12px; border-style:inset; border-left:1px solid #000; border-top:1px solid #000;font-family:arial;">
	<tr style="text-align:center;"><th colspan="16">MYSORE SAREE UDYOG LLP</th></tr>
	<tr style="text-align:center;"><th colspan="16">ONLINE SALES INVOICE</th></tr>
	<tr>
		<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Invoice # </td>
		<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;text-align:center;">	Invoice Date </td>
		<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order # </td>
		<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order Date </td>
	</tr>
	<tr>
		<td colspan="3" style="font-weight:bold;text-align:center;"> <?php echo $invoiceno; ?> </td>
		<td colspan="5" style="font-weight:bold;text-align:center;"> <?php echo $invoicedate; ?> </td>
		<td colspan="3" style="font-weight:bold;text-align:center;"> <?php echo $orderno; ?> </td>
		<td colspan="5" style="font-weight:bold;text-align:center;"> <?php echo $orderdate; ?> </td>
	</tr>
	<tr>
		<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> SOLD TO : </td>
		<td colspan="11" style="font-weight:bold;background-color:#EAEAEA;"> SHIP TO : </td>	
	</tr>
	<tr>
		<td colspan="5"><?php echo $cusnamebilll.'<br />'.$companybilll.'<br/>'.$streetbilll.'<br/>'.$regionbilll.'<br/>'.$countryship.'<br/>'.$telephonebilll.'<br/>'; ?> </td>
		<td colspan="11"><?php echo $cusnameship.'<br />'.$companyship.'<br/>'.$streetship.'<br/>'.$regionship.'<br/>'.$countryship.'<br/>'.$telephoneship.'<br/>'; ?> </td>
	</tr>
	<tr>
		<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> PAYMENT METHOD </td>
		<td colspan="11" style="font-weight:bold;background-color:#EAEAEA;"> SHIPPING METHOD </td>
	</tr>
	<tr>
		<td colspan="5" style=""> <?php echo $order->getPayment()->getMethodInstance()->getTitle(); ?> </td>
		<td colspan="11" style=""> <?php echo $order->getShippingDescription().'<br>(Total Shipping Charges '.$currencySymbol.number_format((float)$order->getShippingAmount(), 2, '.', '').')'; ?> </td>	
	</tr>
	<tr style="text-align:center;">
		<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;"> S No. </td>
		<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;"> PRODUCTS </td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> SKU </td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> Net Wt </td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> Gross Wt </td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> PRICE </td>
		<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;"> Qty </td>
		<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;"> Tax </td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> Item Total </td>
	</tr>
	<?php 
	foreach ($items as $item){
		if($item->getIsQtyDecimal()) {
			$qty1 = ceil(round($item['qty_ordered'])/5);
		} else {
			$qty1 = $item['qty_ordered'];
		}
		$total_qty1 +=  $qty1;
	}
	$boxweight = floor($total_qty1/3);
	$boxweight = $boxweight*0.300;
	$grossboxweight = $boxweight;
	$boxweight = $boxweight / $total_qty1;
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');
	$i = 1;
	foreach ($items as $item){
		$stitching_services_weight1 = 0;
		// $query = "SELECT `blouse_stiching`, `petticoat_stiching`, `pre_stiched_service`, `fall_edge_finishing`, `kurti_stitching`, `lehanga_stitching`, `salwar_kameez_stitching` FROM `custom_optionservice` WHERE `quote_id` = ".$order->getQuoteId()." AND `product_id`=".$item->getProductId()." limit 0,1";
		// $collection = $read->fetchAll($query);
		// foreach ($collection as $value) {
		// 	foreach ($value as $value1) {
		// 		if ($value1 > 0) {
		// 			$collection1 = $read->fetchAll("SELECT * FROM `stichingservices` WHERE `stichingservices_id` = ".$value1);
		// 			foreach ($collection1 as $key => $row) {
		// 				$stitching_services_weight1 += $row['service_weight'];
		// 			}
		// 		}
		// 	}
		// }
		$productweight = $item['weight'] + $stitching_services_weight1;
		$productgrossweight = $boxweight+$productweight;
		if($item->getIsQtyDecimal()) $qty2 = ceil(round($item['qty_ordered'])/5); else $qty2 = $item['qty_ordered'];
		$productgrossweight = $productgrossweight*$qty2;
		$productweight = number_format($productweight,2);
		$productgrossweight = number_format($productgrossweight,2);
		?>
		<tr>
			<td colspan="1" style="text-align:center;"> <?php echo $i; ?> </td>
			<td colspan="3"> <?php echo $item['name']; ?> </td>
			<td colspan="2" style="text-align:center;"> <?php echo $item['sku']; ?> </td>
			<td colspan="2" style="text-align:right;"> <?php echo $productweight; ?> </td>
			<td colspan="2" style="text-align:right;"> <?php echo $productgrossweight; ?> </td>
			<td colspan="2" style="text-align:right;"> <?php echo number_format($item['price'],2); ?> </td>
			<td colspan="1" style="text-align:center;"> <?php if($item->getIsQtyDecimal()) echo number_format($item['qty_ordered'],2); else echo number_format($item['qty_ordered']); ?> </td>
			<td colspan="1" style="text-align:center;"><?php echo number_format(0,2); ?> </td>
			<td colspan="2" style="text-align:right;"> <?php echo number_format($item['row_total'],2); ?> </td>
		</tr>
	<?php $i++; } ?>
	<tr> </tr>
</table>
<br>
<div style="text-align:right;margin-right: 3px;font-family: arial;font-size: 14px;">
	<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> Subtotal : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $currencySymbol.number_format($order['subtotal'],2); ?> </div>
	<?php if($order['discount_amount'] > 0) { ?>
		<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> Discount : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $currencySymbol.number_format($order['discount_amount'],2); ?> </div>
	<?php } ?>
	<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> Shipping & Handling : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $currencySymbol.number_format($order['shipping_amount'],2); ?> </div>
	<?php if($order['cod_fee'] > 0) { ?>
		<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> COD Charges : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $currencySymbol.number_format($order['cod_fee'],2); ?> </div>
	<?php } ?>
	<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> Grand Total : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $currencySymbol.number_format($order['grand_total'],2); ?> </div>
	<div style="text-align:right;font-weight:bold;width:80%;float:left;margin-bottom:5px;"> Grand Total (INR) : </div><div style="margin-bottom:5px;width:20%;text-align:right;float:right;"> <?php echo $basecurrencySymbol.number_format($order['base_grand_total'],2); ?> </div>
</div>
</div>
</body>
</html>