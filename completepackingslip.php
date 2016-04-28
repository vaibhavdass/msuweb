<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head><title>Complete Packing Slip</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<style type="text/css">
			#Table_01 td,#Table_01 th  { border-right:1px solid #000;border-bottom:1px solid #000; }
		</style>
	</head>
	<body bgcolor="#FFFFFF">
		<div  style="width: 766px;page-break-after: always;">
			<?php // print_r($_REQUEST);
				unset($variables['title']);
				$mageFilename = 'app/Mage.php';
				require_once $mageFilename;
				Mage::app();
				$invoice = Mage::getModel('sales/order_invoice')->load($_REQUEST['invoice_id']);
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
				$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');

				foreach ($items as $item){
					if($item->getIsQtyDecimal()) {
						$qty1 = ceil(round($item['qty_ordered'])/5);
					} else {
						$qty1 = $item['qty_ordered'];
					}
					$total_qty1 +=  $qty1;
				}
				$boxweight = ceil($total_qty1/3);
				$boxweight = $boxweight*0.300;
				// $grossboxweight = $boxweight;
				$boxweight = $boxweight / $total_qty1;

				$selectquery = 'SELECT * FROM `packing_list_box_info` WHERE `invoice_id` = '.$_REQUEST['invoice_id'];
				$results = $read->fetchAll($selectquery);
				foreach ($items as $item) {
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
					$netweight = $item['weight'] + $stitching_services_weight1;
					$grossweight = $boxweight + $netweight;
					if($item->getIsQtyDecimal()) $qty2 = ceil(round($item['qty_ordered'])/5); else $qty2 = $item['qty_ordered'];
					$netweight = number_format($netweight,2);
					$grossweight = $grossweight*$qty2;
					$grossweight = number_format($grossweight,2);

					if (sizeof($results) <= 0) {
						$query = 'INSERT INTO `packing_list_box_info` (`invoice_id`, `order_id`, `sku`, `net_weight`, `gross_weight`, `boxnum`, `boxes_size`) VALUES ('.$_REQUEST['invoice_id'].','.$order_id.','.$item['sku'].','.$netweight.','.$grossweight.','.$_REQUEST[$item['sku']].','.$_REQUEST['size'].')';
						$write->query($query);
					}else{
						$query = 'UPDATE `packing_list_box_info` SET `boxnum` = '.$_REQUEST[$item['sku']].', `boxes_size` = '.$_REQUEST['size'].' WHERE `invoice_id` = '.$_REQUEST['invoice_id'].' AND `sku` = '.$item['sku'].'';
						$write->query($query);
					}
				}
			?>
			<table id="Table_01" width="766" border="0" cellpadding="10px" cellspacing="0" style="font-size:12px; border-style:inset; border-left:1px solid #000; border-top:1px solid #000;font-family:arial;">
				<tr style="text-align:center;"><th colspan="16">PACKING SLIP</th></tr>
				<tr>
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Invoice # </td>
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;">	Invoice Date </td>
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order # </td>
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order Date </td>
				</tr>
				<tr>
					<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $invoiceno; ?> </td>
					<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $invoicedate; ?> </td>
					<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $orderno; ?> </td>
					<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $orderdate; ?> </td>
				</tr>
				<tr>
					<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> FROM : </td>
					<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> SOLD TO : </td>
					<td colspan="6" style="font-weight:bold;background-color:#EAEAEA;"> SHIP TO : </td>	
				</tr>
				<tr>
					<td colspan="5"><?php echo 'Mysore Saree Udyog LLP.<br/>			
			#10/A, 2nd Floor, Chandrakiran Building, <br/>				
			Kasturba Road, Bangalore - 560001.		<br/>
			India.	<br/>
			Phone:+91 8722 8023 03/17. 		<br/>
			Email:ecommerce@mysoresareeudyog.com  <br/><br/>
			Regd. Off. : #294, 1st Floor, K. Kamraj Road, Bangalore - 42.'; ?> </td>
					<td colspan="5"><?php echo $cusnamebilll.'<br />'.$companybilll.'<br/>'.$streetbilll.'<br/>'.$regionbilll.'<br/>'.$countryship.'<br/>'.$telephonebilll.'<br/>'; ?> </td>
					<td colspan="6"><?php echo $cusnameship.'<br />'.$companyship.'<br/>'.$streetship.'<br/>'.$regionship.'<br/>'.$countryship.'<br/>'.$telephoneship.'<br/>'; ?> </td>
				</tr>
				<tr>
					<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> PAYMENT METHOD </td>
					<td colspan="7" style="font-weight:bold;background-color:#EAEAEA;"> SHIPPING METHOD </td>	
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;"> TOTAL PACKAGE </td>	
				</tr>
				<tr>
					<td colspan="5"> <?php echo $order->getPayment()->getMethodInstance()->getTitle(); ?> </td>
					<td colspan="7"> <?php echo $order->getShippingDescription(); ?> </td>	
					<!-- <td colspan="7"> <?php // echo $order->getShippingDescription().'<br>(Total Shipping Charges '.$currencySymbol.number_format((float)$order->getShippingAmount(), 2, '.', '').')'; ?> </td>	 -->
					<td colspan="4" style="text-align:center;" id="boxes_count"><?php echo $_REQUEST['size']; ?></td>
				</tr>
				<tr style="text-align: center;">
					<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;width: 40px;"> S No. </td>
					<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;"> PRODUCTS </td>
					<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;"> SKU </td>
					<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> QTY </td>
					<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;text-align: right;"> Net Wt </td>
					<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align: right;"> Gross Wt </td>
					<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align: right;"> Box No. </td>
				</tr>
				<?php 
				$total_qty1 = 0;
				foreach ($items as $item){
					if($item->getIsQtyDecimal()) {
						$qty1 = ceil(round($item['qty_ordered'])/5);
					} else {
						$qty1 = $item['qty_ordered'];
					}
					$total_qty1 +=  $qty1;
				}
				$boxweight = ceil($total_qty1/3);
				// echo $boxweight;
				$boxweight = $boxweight*0.300;
				// $grossboxweight = $boxweight;
				$boxweight = $boxweight / $total_qty1;
				$i = 1;
				$totalproductweight = 0;
				$totalproductgrossweight = 0;
				$totalqty = 0;
				for ($k=1; $k <= $_REQUEST['size']; $k++) {
					foreach ($items as $item){
						if ($k == $_REQUEST[$item['sku']]) {
							
							$fetchboxquery = 'SELECT * FROM `packing_list_box_info` WHERE `invoice_id` = '.$_REQUEST['invoice_id'].' AND `sku` = '.$item['sku'].' limit 0,1';
							$fetchbox = $read->fetchAll($fetchboxquery);
							if($item->getIsQtyDecimal()) $qty2 = ceil(round($item['qty_ordered'])/5); else $qty2 = $item['qty_ordered'];
							$productweight = $fetchbox[0]['net_weight'];
							$totalproductweight += $productweight;
							$productgrossweight = $fetchbox[0]['gross_weight'];
							$totalproductgrossweight += $productgrossweight;
							$totalqty += $item['qty_ordered'];
							?>
							<tr>
								<td style="width: 40px;text-align: center;"> <?php echo $i; ?> </td>
								<td colspan="4"> <?php echo $item['name']; ?> </td>
								<td colspan="3" style="text-align: center;"> <?php echo $item['sku']; ?> </td>
								<td colspan="2" style="text-align: center;"> <?php if($item->getIsQtyDecimal()) echo number_format($item['qty_ordered'],2); else echo round($item['qty_ordered']); ?> </td>
								<td colspan="2" style="text-align: right;"> <?php echo $productweight; ?> </td>
								<td colspan="3" style="text-align: right;"> <?php echo $productgrossweight; ?> </td>
								<td colspan="3" style="text-align: right;"> <?php echo 'Box '.$_REQUEST[$item['sku']]; ?> </td>
							</tr>
						<?php $i++; }
					}
				} ?>
				<tr>
					<td colspan="8" style="text-align: right;font-weight: bold;font-size: 14px;">Total</td>
					<td colspan="2" style="text-align: center;"> <?php $val = explode('.', number_format($totalqty,2)); if ($val[1] > 0) echo number_format($totalqty,2); else echo round($totalqty); ?> </td>
					<td colspan="2" style="text-align: right;"> <?php echo $totalproductweight; ?> </td>
					<td colspan="3" style="text-align: right;"> <?php echo $totalproductgrossweight; ?> </td>
					<td colspan="3" style="text-align: right;"> </td>
				</tr>
				<tr>
					<td colspan="16" style="font-weight:bold;padding-bottom:75px;"></td>
				</tr>
			</table>
		</div><br><br><br>

		<?php for ($j=1; $j <= $_REQUEST['size']; $j++) { ?>
			<div  style="width: 766px;page-break-after: always;">
				<table id="Table_01" width="766" border="0" cellpadding="10px" cellspacing="0" style="font-size:12px; border-style:inset; border-left:1px solid #000; border-top:1px solid #000;font-family:arial;">
					<tr style="text-align:center;"><th colspan="16">BOX <?php echo $j; ?></th></tr>
					<tr>
						<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Invoice # </td>
						<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;">	Invoice Date </td>
						<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order # </td>
						<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;text-align:center;"> Order Date </td>
					</tr>
					<tr>
						<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $invoiceno; ?> </td>
						<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $invoicedate; ?> </td>
						<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $orderno; ?> </td>
						<td colspan="4" style="font-weight:bold;text-align:center;"> <?php echo $orderdate; ?> </td>
					</tr>
					<tr>
						<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> FROM : </td>
						<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> SOLD TO : </td>
						<td colspan="6" style="font-weight:bold;background-color:#EAEAEA;"> SHIP TO : </td>	
					</tr>
					<tr>
						<td colspan="5"><?php echo 'Mysore Saree Udyog LLP.<br/>			
			#10/A, 2nd Floor, Chandrakiran Building, <br/>				
			Kasturba Road, Bangalore - 560042.		<br/>
			India.	<br/>
			Phone:+91 8722 8023 03/17. 		<br/>
			Email:ecommerce@mysoresareeudyog.com  <br/><br/>
			Regd. Off. : #294, 1st Floor, K. Kamraj Road, Bangalore - 42.'; ?> </td>
						<td colspan="5"><?php echo $cusnamebilll.'<br />'.$companybilll.'<br/>'.$streetbilll.'<br/>'.$regionbilll.'<br/>'.$countryship.'<br/>'.$telephonebilll.'<br/>'; ?> </td>
						<td colspan="6"><?php echo $cusnameship.'<br />'.$companyship.'<br/>'.$streetship.'<br/>'.$regionship.'<br/>'.$countryship.'<br/>'.$telephoneship.'<br/>'; ?> </td>
					</tr>
					<tr>
						<td colspan="5" style="font-weight:bold;background-color:#EAEAEA;"> PAYMENT METHOD </td>
						<td colspan="11" style="font-weight:bold;background-color:#EAEAEA;"> SHIPPING METHOD </td>	
					</tr>
					<tr>
						<td colspan="5"> <?php echo $order->getPayment()->getMethodInstance()->getTitle(); ?> </td>
						<td colspan="11"> <?php echo $order->getShippingDescription(); ?> </td>	
						<!-- <td colspan="7"> <?php // echo $order->getShippingDescription().'<br>(Total Shipping Charges '.$currencySymbol.number_format((float)$order->getShippingAmount(), 2, '.', '').')'; ?> </td>	 -->
					</tr>
					<tr style="text-align: center;">
						<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;width: 40px;"> S No. </td>
						<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;"> PRODUCTS </td>
						<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;"> SKU </td>
						<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;"> QTY </td>
						<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align: right;"> Net Wt </td>
						<td colspan="3" style="font-weight:bold;background-color:#EAEAEA;text-align: right;"> Gross Wt </td>
					</tr>
					<?php $i = 0;
						$totalproductweight = 0;
						$totalproductgrossweight = 0;
						$totalqty = 0;
						foreach ($items as $item){
							if ($j == $_REQUEST[$item['sku']]) {
								$fetchboxquery = 'SELECT * FROM `packing_list_box_info` WHERE `invoice_id` = '.$_REQUEST['invoice_id'].' AND `sku` = '.$item['sku'].' limit 0,1';
								$fetchbox = $read->fetchAll($fetchboxquery);
								if($item->getIsQtyDecimal()) $qty2 = ceil(round($item['qty_ordered'])/5); else $qty2 = $item['qty_ordered'];
									$productweight = $fetchbox[0]['net_weight'];
									$totalproductweight += $productweight;
									$productgrossweight = $fetchbox[0]['gross_weight'];
									$totalproductgrossweight += $productgrossweight;
									$totalqty += $item['qty_ordered'];
									$i++; 
									?>
									<tr>
										<td style="width: 40px;text-align: center;"> <?php echo $i; ?> </td>
										<td colspan="4"> <?php echo $item['name']; ?> </td>
										<td colspan="3" style="text-align: center;"> <?php echo $item['sku']; ?> </td>
										<td colspan="2" style="text-align: center;"> <?php if($item->getIsQtyDecimal()) echo number_format($item['qty_ordered'],2); else echo round($item['qty_ordered']); ?> </td>
										<td colspan="3" style="text-align: right;"> <?php echo $productweight; ?> </td>
										<td colspan="3" style="text-align: right;"> <?php echo $productgrossweight; ?> </td>
									</tr>
								<?php }
							} ?>
					<tr>
						<td colspan="8" style="text-align: right;font-weight: bold;font-size: 14px;">Total</td>
						<td colspan="2" style="text-align: center;"> <?php $val = explode('.', number_format($totalqty,2)); if ($val[1] > 0) echo number_format($totalqty,2); else echo round($totalqty); ?> </td>
						<td colspan="3" style="text-align: right;"> <?php echo $totalproductweight; ?> </td>
						<td colspan="3" style="text-align: right;"> <?php echo $totalproductgrossweight; ?> </td>
					</tr>
					<tr>
						<td colspan="14" style="font-weight:bold;padding-bottom:75px;"> </td>
					</tr>
				</table>
			</div><br>
		<?php } ?>
	</body>
</html>