<?php
?>
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
   $date_string = $invoicedate;

 $date = strtotime($date_string);
 $invoicedaten = date('d/m/y', $date);
  $invoicecurrencycode=$invoice['order_currency_code'];
  /* echo "<pre>";
  print_r($invoice);
  exit;*/
   $order_id=$invoice['order_id'];
  $order=Mage::getModel('sales/order')->load($order_id);
  $payment = $order->getPayment()->getMethodInstance()->getTitle();
 /* echo "<pre>";
  print_r($payment);
  exit;*/
   $shipping=$order->getShippingAddress()->getData();
	   
	      
		     $cusnameship=$shipping['firstname'].$shipping['lastname'];
		       $companyship=$shipping['company']; 
		       $streetship=$shipping['street'];
		        $regionship=$shipping['city'].",".$shipping['region'];
			   $countryship=$shipping['country_id'];
			   $telephoneship=$shipping['telephone'];
					 
		  
	  
	   $billing=$order->getBillingAddress()->getData();
			 	 $cusnamebilll=$billing['firstname'].$billing['lastname'];
	            $companybilll=$billing['company']; 
		        $streetbilll=$billing['street'];
		        $regionbilll=$billing['city'].",".$billing['region'];
			    $countrybilll=$billing['country_id'];
			    $telephonebilll=$billing['telephone'];
	   
	   $items = $order->getAllItems();
	  
			 
	?>
						<HTML>
							<head><title>SDF Document</title></head>

<BODY TEXT="#000000">
<div style=" margin: 0pt auto; ">
<table frame="void" cellspacing="0" cols="1"  border="0" style="">
  <colgroup>
  <col width="612" />
  </colgroup>
  <tbody>
   
    <tr>
      <td height="35" align="center" valign="bottom" sdnum="16393;16393;General"><strong>APPENDIX I</strong></td>
    </tr>
    <tr>
      <td height="24" align="center" valign="bottom" sdnum="16393;16393;General"><strong>FORM SDF</strong></td>
    </tr>
    <tr>
      <td height="17" align="center" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="center" valign="bottom" sdnum="16393;16393;General">Shipping Bill No.<?php echo $invoiceno ?> Date :<?php echo $invoicedaten ?></td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="left" valign="bottom" sdnum="16393;16393;General">Declaration under Foreign Exchange Regulation Act, 1973 :</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="50" align="left" valign="bottom" sdnum="16393;16393;General">1. I/We hereby declare that I/We am/are the *SELLER/CONSIGNOR of the goods in respect of which this declaration is made and that the particulars given in the &nbsp;&nbsp;Shipping Bill no _<?php echo $invoiceno ?> dated <?php echo $invoicedaten ?> are true and that,</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="48" align="left" valign="bottom" sdnum="16393;16393;General">A)* The value as contracted with the buyer is same as the full export value in the above shipping bills.</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="96" align="left" valign="bottom" sdnum="16393;16393;General">B)* The full export value of the goods are not ascertainable at the time of export and that the value declared is that which I/We, having regard to the prevailing market conditions, accept to receive on the sale of goods in the overseas market.</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="120" align="left" valign="bottom" sdnum="16393;16393;General">2. I/We undertake that I/We will deliver to the <?php if($order->getPayment()->getMethodInstance()->getCode() == 'icici_standard'){ echo 'ICICI'; } else { echo 'HDFC'; } ?> Bank the foreign exchange representing the full export value of the goods on or before @ ___________________ in the manner prescribed in Rule 9 of the Foreign Exchange Regulation Rules, 1974. </td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="48" align="left" valign="bottom" sdnum="16393;16393;General">3. I/We further declares that I/We am/are resident in India and I/We have place of Business in India.</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="48" align="left" valign="bottom" sdnum="16393;16393;General">4. I./We am/are Or am/are not in Caution list of the Reserve Bank of India.</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="left" valign="bottom" sdnum="16393;16393;General">Date : <?php echo date('d/m/y'); ?></td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="bottom" sdnum="16393;16393;General">For Mysore Saree Udyog LLP.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="bottom" sdnum="16393;16393;General"></td>
    </tr>
    <tr>
      <td height="17" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="bottom" sdnum="16393;16393;General" style="padding-right: 186px;">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</div>
</html>

		 <?php
	   
// echo "<pre>";
//print_r($invoice);
//exit;

//$order = Mage::getModel('sales/order')->loadByIncrementId($_GET['order']);

?>