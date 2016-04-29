
<script type="text/javascript">
                                 function printpage()
							               {
												window.print();
												}
							</script>
							<?php
//echo $invoice_id=$this->getRequest()->getParam('id');


$mageFilename = 'app/Mage.php';
 require_once $mageFilename;
 Mage::app();
 
  $invoice = Mage::getModel('sales/order_invoice')->load($_GET['id']);
  $invoiceno=$invoice['increment_id'];
  $invoicedate=$invoice['created_at'];
  $invoicecurrencycode=$invoice['order_currency_code'];
   $date_string = $invoicedate;

 $date = strtotime($date_string);
 $invoicedaten = date('d/m/y', $date);

   $order_id=$invoice['order_id'];
  $order=Mage::getModel('sales/order')->load($order_id);
  $payment = $order->getPayment()->getMethodInstance()->getTitle();

   $shipping=$order->getShippingAddress()->getData();
	   
	$shipmentCollection = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($order_id)->load();
	foreach ($shipmentCollection as $shipment){

            foreach($shipment->getAllTracks() as $tracknum)
            {
                $tracknums[]=$tracknum->getNumber();
				$ship_date = $tracknum->getCreatedAt();
            }

	}
	   $tracknums_str = implode(",",$tracknums);
	   $items = $order->getAllItems();
	  
			 
	?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>EVD</title>
	<meta name="description" content="">
	<meta name="author" content="Nuvodev" >

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="css/style.css">
	
</head>
<body>
<table cellpadding="5px" border="0px" align="center"style="text-align:center; font-family:arial;width:685px;" >

<tr><td colspan="8" style="font-size:12px;font-weight:bold;text-decoration:underline;" >Annexure-A </td></tr>
<tr><td colspan="8" style="font-size:12px;font-weight:bold;">EXPORT VALUE DECLARATION  </td></tr>

<tr><td colspan="8" style="font-size:12px;">(See Rule 7 of Customs Valuation (Determination of Value of Export Goods) Rules, 2007.)  </td></tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;"><td colspan="1" style="width:32px;">1. </td><td>Shipping Bill No. & Date:- </td><td colspan="4"><?php echo $tracknums_str ."; ". $ship_date; ?></td></tr>
<tr style="text-align:left;font-size:12px;font-weight:bold;"><td colspan="1" style="width:32px;">2. </td><td> Invoice No. & Date:-  </td><td  colspan="4"><?php echo $invoiceno ."; ". $invoicedaten; ?></td></tr>
<tr style="text-align:left;font-size:12px;font-weight:bold;"><td colspan="1" style="width:32px;">3. </td><td>Nature of Transaction  </td><td  colspan="4"></td></tr>
<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;"></td>
<td style="width:5%;">Sale</td>
<td style="width:20%;">Sale on consignment </td>
<td style="width:10%;"> Gift    </td>
<td style="width:10%;">Basis  </td>
<td style="width:10%;">Sample </td>
<td style="width:10%;">Other  </td>

</tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td style="width:32px;">4.</td>
<td style="width:20%;"> Method of Valuation <br/>(See Export Valuation Rules) </td>
<td style="width:10%;"> Rule 3     </td>
<td style="width:10%;">Rule 4  </td>
<td style="width:10%;">Rule 5 </td>
<td style="width:10%;">Rule 6  </td>

</tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td style="width:32px;">5.</td>
<td style="width:20%;"> Whether seller and buyer <br/> are related </td>
<td style="width:10%;">No  </td>
<td style="width:10%;"> </td>
<td></td>
<td></td>
</tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td style="width:32px;">6.</td>
<td style="width:20%;">  If yes, whether relationship <br/>has influenced the price </td>
<td style="width:10%;"> No  </td>
<td style="width:10%;">   </td>
<td></td>
<td></td>
</tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;">7. </td>
<td colspan="6"> Terms of Payment: Advance Payment  </td></tr>
<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;">8. </td>
<td colspan="6"> Terms of Delivery: C I F  </td></tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;">9. </td>
<td colspan="5"> Previous exports of identical/ similar goods, if any  </td></tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;"></td>
<td colspan="6" style="width:10%;">Shipping Bill No. and date:  </td>
</tr>


<tr style="text-align:left;font-size:12px;font-weight:bold;">
<td colspan="1" style="width:32px;">10. </td>
<td colspan="6"> Any other relevant information (Attach separate sheet, if necessary)  </td></tr>

<tr style="text-align:left;font-size:12px;font-weight:bold;"><td colspan="6" style="text-decoration:underline;" >DECLARATION   </td></tr>


<tr style="text-align:left;font-size:12px;">
<td colspan="1" style="width:32px;">1. </td>
<td colspan="6">  I/We hereby declare that the information furnished above is true, complete and correct in every respect.  </td></tr>
<tr style="text-align:left;font-size:12px;">
<td colspan="1" style="width:2%;">2. </td>
<td colspan="6">  I/We also undertake to bring to the notice of proper officer any particulars which subsequently come to my/our knowledge which will have bearing on a valuation. </td></tr>

<tr style="text-align:left;font-size:12px;">
<td colspan="7" style="width:32px;">Place: Bangalore </td>
</tr>

<tr style="text-align:left;font-size:12px;">
<td colspan="7" style="width:32px;">Date: <?php echo date('d/m/y');?></td>
</tr>


<tr style="text-align:right;font-size:12px;font-weight:bold;">
<td colspan="7" style="width:32px;">SIGNATURE OF THE Mysore Saree Udyog LLP. </td>
</tr>







</table>
</body>
</html>