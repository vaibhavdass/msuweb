<script type="text/javascript">
  function printpage() {
    window.print();
  }
</script>
<?php $mageFilename = 'app/Mage.php';
  require_once $mageFilename;
  Mage::app();
  $invoice = Mage::getModel('sales/order_invoice')->load($_REQUEST['id']);
  $invoiceno = $invoice['increment_id'];
  $invoicedate=$invoice['created_at'];
  $invoicecurrencycode=$invoice['order_currency_code'];
  $date_string = $invoicedate;
  $date = strtotime($date_string);
  $invoicedaten = date('d/m/y', $date);
  $order_id=$invoice['order_id'];
  $order=Mage::getModel('sales/order')->load($order_id);
  if ($order->getPayment()->getMethodInstance()->getCode() == 'icici_standard') {
    $authorised_dealer_code = '6390230-8400009';
  }else{
    $authorised_dealer_code = '0510010-8400009';
  }
  $payment = $order->getPayment()->getMethodInstance()->getTitle();
  $shipping=$order->getShippingAddress()->getData();
	$cusnameship=$shipping['firstname'].$shipping['lastname'];
  $companyship=$shipping['company']; 
  $streetship=$shipping['street'];
  $regionship=$shipping['city'].",".$shipping['region'];
  $countryship=$shipping['country_id'];
  $telephoneship=$shipping['telephone'];
	$billing=$order->getBillingAddress()->getData();
  $cusnamebilll=$billing['firstname']." ".$billing['lastname'];
  $companybilll=$billing['company']; 
  $streetbilll=$billing['street'];
  $regionbilll=$billing['city'].",".$billing['region'];
  $countrybilll=$billing['country_id'];
  $telephonebilll=$billing['telephone'];
  $items = $order->getAllItems();
  $read = Mage::getSingleton('core/resource')->getConnection('core_read');
  $stitching_services_weight1 = 0;
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
  $boxweight += $stitching_services_weight1;
  // echo $boxweight;
  $query = 'SELECT `boxes_size` FROM `packing_list_box_info` WHERE `invoice_id` = '.$_GET['id'];
  $boxescount = $read->fetchOne($query);
  // if ($boxescount <= 0) {
  //   echo 'Please Create Packing Slip';
  // }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>SHIPPER'S LETTER OF INSTRUCTIONS</title>
  </head>
  <div style=" margin: 0pt auto; ">
    <body>
      <table cellspacing="0" cols="15" border="1" width="70%" >
        <colgroup>
          <col width="94" />
          <col width="41" />
          <col width="68" />
          <col width="32" />
          <col width="32" />
          <col width="68" />
          <col width="68" />
          <col width="72" />
          <col width="32" />
          <col width="80" />
          <col width="72" />
          <col width="72" />
          <col width="78" />
          <col width="32" />
          <col width="77" />
        </colgroup>
				<tbody>
          <!--<tr>
            <td width="94" height="18" align="left" valign="bottom" sdnum="16393;16393;General"><U><a href="#INDEX.A1">R</a></U></td>
            <td width="41" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="68" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="32" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="32" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="68" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="68" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="72" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="32" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="80" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="72" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="72" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="78" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="32" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
            <td width="77" align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
          </tr>-->
          <tr>
            <td colspan="15" height="18" align="center" valign="bottom" sdnum="16393;16393;General"><strong>SHIPPER'S LETTER OF INSTRUCTIONS</strong></td>
          </tr>
          <tr>
            <td colspan="2" height="33" align="left" valign="middle" sdnum="16393;16393;General"><strong>Shipper Name:</strong></td>
            <td colspan="7" align="center" valign="middle" sdnum="16393;16393;General">Mysore Saree Udyog<br /></td>
            <td align="left" valign="middle" sdnum="16393;16393;General"><strong>Date:</strong></td>
            <td colspan="5" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo $invoicedaten ?> <br /></td>
          </tr>
          <tr>
            <td colspan="2" height="33" align="left" valign="middle" sdnum="16393;16393;General"><strong>Email:</strong></td>
            <td colspan="7" align="center" valign="middle" sdnum="16393;16393;General">customerservice@mysoresareeudyog.com<br /></td>
            <td align="left" valign="middle" sdnum="16393;16393;General"><strong>Phone:</strong></td>
            <td colspan="5" align="center" valign="bottom" sdnum="16393;16393;General">+918722802303/17<br /></td>
          </tr>
          <tr>
            <td colspan="2" height="33" align="left" valign="middle" sdnum="16393;16393;General"><strong>Consignee Name:</strong></td>
            <td colspan="7" align="center" valign="middle" sdnum="16393;16393;General"> <?php echo $cusnamebilll ?><br /></td>
            <td align="left" valign="middle" sdnum="16393;16393;General"><strong>Invoice No.</strong></td>
            <td colspan="5" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo  $invoiceno ?><br /></td>
          </tr>
          <tr>
            <td colspan="15" height="18" align="center" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><br /></td>
          </tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">IE CODE NO (10 DIGIT) :</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">0703023012<br /></td>
          </tr>
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">TIN NUMBER :</td>
            <!-- <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">29330085530<br /></td> -->
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">29701262761<br /></td>
          </tr>	
          <!-- <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">CIN NUMBER :</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">U52322KA1992PTC013679<br /></td>
          </tr>  -->
          <!-- <tr>	 -->
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">Authorised Dealer Code :</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo $authorised_dealer_code; ?><br /></td>
          </tr>	
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">BANK AD CODE # (PART I &amp; II) :</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General"><br /></td>
          </tr>
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">CURRENCY OF INVOICE</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo $invoicecurrencycode ?><br /></td>
          </tr>
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">INCOTERMS : F O B / C &amp; F / C &amp; I / C I F / D D P :</td>
            <?php if (number_format($order['fee_amount'],2) > 0 || $countryship == 'AE' || $countryship == 'US' || $countryship == 'HK') { ?>
              <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">D D P<br /></td>
            <?php } else { ?>
              <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">C I F<br /></td>
            <?php } ?>
          </tr>
          <tr>
            <td colspan="8" height="33" align="left" valign="bottom" sdnum="16393;16393;General">NATURE OF PAYMENT * : D P / D A / A P / OTHERS</td>
            <td colspan="8" align="center" valign="bottom" sdnum="16393;16393;General">A P<?php //echo $payment ?><br /></td>
          </tr>
          <tr>
            <td colspan="15" height="18" align="left" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>Details to be declared for preparation of Shipping Bill</strong></td>
          </tr>
          <tr>
            <td colspan="4" height="33" align="left" valign="bottom" sdnum="16393;16393;General">FOB VALUE</td>
            <td align="center" valign="bottom" sdnum="16393;16393;General"><strong>:</strong></td>
            <td colspan="10" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo number_format($order['subtotal'],2); ?><br /></td>
          </tr>
          <tr>
            <td colspan="4" height="33" align="left" valign="bottom" sdnum="16393;16393;General">FREIGHT (IF ANY)</td>
            <td align="center" valign="bottom" sdnum="16393;16393;General"><strong>:</strong></td>
            <td colspan="10" align="center" valign="bottom" sdnum="16393;16393;General"><?php echo number_format($order['shipping_amount'] * 99.5 /100,2); ?><br /></td>
          </tr>
          <tr>
            <td colspan="4" height="33" align="left" valign="bottom" sdnum="16393;16393;General">INSURANCE (IF ANY)</td>
            <td align="center" valign="bottom" sdnum="16393;16393;General"><strong>:</strong></td>
            <td colspan="10" align="center" valign="bottom" sdnum="16393;16393;General"><br /><?php echo number_format($order['shipping_amount'] * 0.5 /100,2); ?></td>
          </tr>
          <tr>
            <td colspan="4" height="33" align="left" valign="bottom" sdnum="16393;16393;General">COMMISSION (IF ANY)</td>
            <td align="center" valign="bottom" sdnum="16393;16393;General"><strong>:</strong></td>
            <td colspan="10" align="center" valign="bottom" sdnum="16393;16393;General"><br /></td>
          </tr>
          <tr>
            <td colspan="4" height="33" align="left" valign="bottom" sdnum="16393;16393;General">DISCOUNT (IF ANY)</td>
            <td align="center" valign="bottom" sdnum="16393;16393;General"><strong>:</strong></td>
            <td colspan="10" align="center" valign="bottom" sdnum="16393;16393;General"><br /><?php echo number_format($order['discount_amount'] * -1,2); ?></td>
          </tr>
          <tr>
              <td colspan="11" height="20" align="left" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>Description of Goods to be declared on Shipping Bill</strong></td>
              <td colspan="2" rowspan="3" align="left" valign="top" sdnum="16393;16393;General" style="vertical-align: middle;">NO. OF PKGS. :</td>
              <td colspan="2" rowspan="3" align="center" valign="bottom" sdnum="16393;16393;General" style="vertical-align: middle;"><?php echo $boxescount; ?></td>
          </tr>
          <tr>
              <td colspan="11" rowspan="5" height="100" align="left" valign="top" sdnum="16393;16393;General">
              <?php foreach ($items as $item) { 
                echo $item['name'] .' - '.$item['sku']; ?> <br />
              <?php } ?>
              </td>
          </tr>
          <!-- <tr>
              <td colspan="2" rowspan="2" align="left" valign="top" sdnum="16393;16393;General">NET WT. :</td>
              <td colspan="2" rowspan="2" align="center" valign="top" sdnum="16393;16393;General"><?php echo number_format($order['weight'],2); ?><br /></td>
          </tr> -->
          <tr> </tr>
          <tr>
              <td colspan="2" rowspan="1" align="left" valign="top" sdnum="16393;16393;General" style="vertical-align: middle;">GROSS WT. :</td>
              <td colspan="2" rowspan="1" align="center" valign="bottom" sdnum="16393;16393;General" style="vertical-align: middle;"><?php echo number_format($order['weight']+$boxweight,2); ?></td>
          </tr>
          <tr>
              <td colspan="2" rowspan="2" align="left" valign="bottom" sdnum="16393;16393;General">VOLUME WT. :</td>
              <td colspan="2" rowspan="2" align="center" valign="bottom" sdnum="16393;16393;General"><br /></td>
          </tr>
          <tr> </tr>
          <tr>
              <td colspan="11" height="20" align="left" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>Description of Goods to be declared on AWB</strong></td>
              <!-- <td colspan="2" align="left" valign="bottom" sdnum="16393;16393;General">VOLUME WT. :</td>
              <td colspan="2" align="center" valign="bottom" sdnum="16393;16393;General"><br /></td> -->
              <td colspan="4" align="center" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>DIMENSION (IN CMS) of each pkg.</strong></td>
          </tr>
          <tr>
              <td colspan="11" rowspan="5" height="100" align="left" valign="top" sdnum="16393;16393;General">
                <?php foreach ($items as $item) { echo $item['name'].' - '.$item['sku']; ?><br />
                <?php } ?><br /></td>
          </tr>
          <tr>
              <td colspan="4" rowspan="3" align="center" valign="bottom" sdnum="16393;16393;General"></td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr>
              <td colspan="4" align="center" valign="bottom" sdnum="16393;16393;General">L  X  B  X H</td>
          </tr>

          <tr>
              <td colspan="15" height="18" align="left" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>Special Instructon, If any</strong></td>
          </tr>
          <tr>
              <td colspan="15" rowspan="4" height="80" align="left" valign="top" sdnum="16393;16393;General"><strong><br />
          </strong></td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr> </tr>
          <tr>
              <td colspan="6" height="34" align="left" valign="top" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>TYPE OF SHIPPING BILL ( CIRCLE YES or NO)</strong></td>
              <td colspan="9" align="left" valign="top" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>BELOW DETAILS REQUIRED TO BE DECLARED ON INVOICE</strong></td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">a) FREE TRADE SAMPLE (NON-COMM)</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">FREE TRADE SAMPLE - VALUE FOR CUSTOMS - NOT FOR SALE</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">b) DUTY FREE COMMERCIAL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General"><em>NOTHING SPECIFIC</em></td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">c) EOU SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">GOODS MANUFACTURED BY EOU &amp; GREEN CARD NUMBER OF EOU</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">d) DUTY DRAWBACK</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">DRAWBACK SL. NO &amp; RATE, PRESENT MARKET VALUE (PMV) OF SHPT</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">e) DUTIABLE SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">RATE OF CESS/ DUTY TO BE PAID AT CUSTOMS</td>
          </tr>
          <tr>
              <td colspan="5" height="35" align="left" valign="bottom" sdnum="16393;16393;General">f) DEPB SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">DEPB SL NO., RATE, PRODUCT GROUP CODE, SION ( STANDARD INPUT OUTPUT NORMS) SERIAL NO.</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">g) DFRC SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General"> DFRC PRODUCT GROUP CODE, SION SL. NO</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">h) EPCG SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General"> EPCG LICENCE NUMBER &amp; DATE</td>
          </tr>
          <tr>
              <td colspan="5" height="36" align="left" valign="bottom" sdnum="16393;16393;General">i) DEEC SHIPPING BILL</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">DEEC REGISTRATION NUMBER AT AIR CARGO, SL. NO. IN PART (E)  AND PART (C) IN DEEC BOOK, QUANTITY</td>
          </tr>
          <tr>
              <td colspan="5" height="18" align="left" valign="bottom" sdnum="16393;16393;General">j) REPAIR &amp; RETURN</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">GOODS BEING EXPORTED ON REPAIR AND RETURN BASIS</td>
          </tr>
          <tr>
              <td colspan="5" height="36" align="left" valign="bottom" sdnum="16393;16393;General">k) DUTY DRAWBACK (SECTION 74)</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >NO</td>
              <td colspan="9" align="left" valign="top" sdnum="16393;16393;General">GOODS BEING EXPORTED UNDER SECTION 74 ( DUTY DRAWBACK) , IMPORT BILL OF ENTRY AND IMPORT INVOICE NOS.</td>
          </tr>
          <tr>
              <td colspan="15" height="18" align="left" valign="bottom" bgcolor="#FFCC00" sdnum="16393;16393;General"><strong>Please TICK &amp; LIST the documents provided to Shipper with the shipment :</strong></td>
          </tr>
          <tr>
              <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">1. INVOICE (4 COPIES)</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General">7. ARE-1 FORM IN DUPLICATE</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="right" valign="bottom" sdval="13" sdnum="16393;16393;General">13</td>
              <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >Commercial Invoice</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >6<br /></td>
          </tr>
          <tr>
              <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">2. PACKING LIST (4 COPIES)</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General">8. VISA/AEPC ENDORSEMENT</td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
              <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="right" valign="bottom" sdval="14" sdnum="16393;16393;General">14</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >SLI</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >2<br /></td>
          </tr>
          <tr>
          <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">3. SDF FORM IN DUPLICATE</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General">9. LAB ANALYSIS REPORT</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="right" valign="bottom" sdval="15" sdnum="16393;16393;General">15</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >SDF</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >2<br /></td>
          </tr>
          <tr>
          <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">4. NON-DG DECLARATION</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General">10. MSDS </td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="right" valign="bottom" sdval="16" sdnum="16393;16393;General">16</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >EVD</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >2<br /></td>
          </tr>
          <tr>
          <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">5. PURCHASE ORDER COPY</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General">11. PHYTOSANITARY CERT</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="right" valign="bottom" sdval="17" sdnum="16393;16393;General">17</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >AWB</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><br /></td>
          </tr>
          <tr>
          <td height="28" align="left" valign="bottom" sdnum="16393;16393;General">6. GR FORM/GR WAIVER</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General">12. GSP CERTIFICATE</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="right" valign="bottom" sdval="18" sdnum="16393;16393;General">18</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >Packing Slip</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >1<br /></td>
          </tr>
          <tr>
          <td height="28" align="left" valign="bottom" colspan="9" sdnum="16393;16393;General"></td>
          <td align="right" valign="bottom" sdval="18" sdnum="16393;16393;General">19</td>
          <td colspan="3" align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >Textile Check List</td>
          <td align="left" valign="bottom" sdnum="16393;16393;General"><U><br />
          </U></td>
          <td align="left" valign="bottom" sdnum="16393;16393;General" style="text-align:center;" >2<br /></td>
          </tr>
          <tr>
          <td height="17" colspan="10" align="left" valign="bottom" bgcolor="#FFFFFF" sdnum="16393;16393;General"> 
          Please indicate API (As per Invoice) if any detail is mentioned in the Invoice.<br/>
          We hereby confirm that the above details declared are true and correct. <br/>
          We confirm that our company s IEC &amp; Bank AD Code Details are registered with EDI System of Air Cargo - Mumbai<br/><br/><br/><br/><br/><br/>
          </td>
          <!-- <td height="17" colspan="7" align="left" valign="bottom" bgcolor="#FFFFFF" sdnum="16393;16393;General" style="text-align:center;" > <br/><br/><br/><br/><br/>SIGNATURE/STAMP of Mysore Saree Udyog Pvt. Ltd.</td> -->
          <td height="17" colspan="7" align="left" valign="bottom" bgcolor="#FFFFFF" sdnum="16393;16393;General" style="text-align:center;" > <br/><br/><br/><br/><br/>SIGNATURE/STAMP of Mysore Saree Udyog LLP.</td>
          </tr>
          </tbody>
          </table>
          </body>
          </div>
          </html>
          <input type="button" value="Print this page" onclick="printpage()" />
          <?php
          //echo "<pre>";
          //print_r($invoice);
          //exit;
          // echo "<pre>";
          //print_r($invoice);
          //exit;
          //$order = Mage::getModel('sales/order')->loadByIncrementId($_GET['order']);
          ?>