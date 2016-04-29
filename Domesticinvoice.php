<?php ?>
<script type="text/javascript">
  function printpage() {
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
  $ordernum = $order->getRealOrderId();
  $order_date = date('d/m/y', strtotime($order->getCreatedAt()));
  //$order_date = $order->getCreatedAt();
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

  $shipping=$order->getShippingAddress()->getData();      
  $cusnameship=$shipping['firstname']." ".$shipping['lastname'];
  $companyship=$shipping['company']; 
  $streetship=$shipping['street'];
  $regionship=$shipping['city'].", ".$shipping['region'].", ".$shipping['postcode'];
  $countryship=$shipping['country_id'];
  $telephoneship=$shipping['telephone'];


  $items = $order->getAllItems();
  ?>
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Domestic Invoice</title>
      <style type="text/css">
        body{font:normal 12px Arial; color:#000; text-align:left;}
        body, ul, li, tr, th, td, table, h1, p{margin: 0; padding: 0; border: 0; outline: 0; text-decoration: none; }
        th{ border-bottom:1px solid #000; border-top:1px solid #000; padding:3px 0;}
        ol, ul {list-style: none}
        .main-wrapper{margin:0 auto; width:900px; overflow:hidden; clear:both; border:1px solid #ccc; padding:10px;}
        .header .lft-div{ width:200px; float:left}
        .header .rht-div{ width:200px; float:right}
        .clr{clear:both; margin:0; padding:0; line-height:0; overflow:hidden}
        ul.para li{list-style-type:none; line-height:20px;}
        ul.para li span{display:block; float:left; width:10px;}
        ul.para li label{float:left; padding-left:10px; width:625px;}
        .grand_total { border-top: 1px solid #000; }
      </style>
    </head>
    <body>
      <div class="main-wrapper" style="border: 10px solid; margin: 0pt auto; width: 651px; padding: 10px;">
        <div class="header">
          <div class="lft-div" style="width:300px;">
            <span><img src="/skin/frontend/default/default/images/logo_email.gif" /></span><br/>
            <span>#10/A, 2nd Floor, Chandrakiran Building, <br> Kasturba Road,</span> <span>Bangalore - 560001.</span><br/>
            <span>Phone : +91 8722 8023 03/17</span><br/>
            Email: ecommerce@mysoresareeudyog.com<br/> URL: www.mysoresareeudyog.com <br /><br />
            Regd. Off. : <br /> #294, 1st Floor, K. Kamraj Road, Bangalore - 560042.
          </div>
          <div class="rht-div">
            <span>LLPIN No. : AAD 6688</span><br />
            <span>T. I. N. : 29701262761</span><br />
            <span>Order No. : <?php echo $ordernum ?></span><br />
            <span>Order Date : <?php echo $order_date ?></span><br />
            <span>Invoice No. : <?php echo $invoiceno ?></span><br />
            <span>Invoice Date : <?php echo $invoicedaten ?></span>
          </div>
        </div>
        <div class="clr"></div><br />
        <table style="width:100%;">
          <tr>
            <th style="width:50%;padding-left: 10px;text-align:left;">Shipping Address</th>
            <th style="width:50%;padding-left: 10px;text-align:left;">Billing Address</th>
          </tr>
          <tr>
            <td style="font-size:14px;padding: 5px 10px;border-right: 1px solid #000;"><?php echo strtoupper($cusnameship).'<br />'.strtoupper($companyship).'<br/>'.strtoupper($streetship).'<br/>'.strtoupper($regionship).'<br/>'.strtoupper($countryship).'<br/>'.$telephoneship.'<br/>'; ?></td>
            <td style="font-size:14px;padding: 5px 10px;"><?php echo strtoupper($cusnamebilll).'<br />'.strtoupper($companybilll).'<br/>'.strtoupper($streetbilll).'<br/>'.strtoupper($regionbilll).'<br/>'.strtoupper($countryship).'<br/>'.$telephonebilll.'<br/>'; ?></td>
          </tr>
        </table>
        <div>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <col style="width:3%" />
            <col style="width:5%" />
            <col style="width:30%" />
            <col style="width:10%" />
            <col style="width:6%" />
            <col style="width:5%" />
            <col style="width:8%" />
            <col style="width:15%" />
            <tr>
              <th valign="top" align="left">SI</th>
              <th valign="top" align="left">Unit</th>
              <th valign="top" align="left">Description</th>
              <th valign="top" align="center">Weight</th>
              <th valign="top" align="left">Qty.</th>
              <th valign="top" align="left">Pcs.</th>
              <th valign="top" align="right">Rate</th>
              <th valign="top" align="right">Amount(<img src="/skin/frontend/ultimo/default/images/rupee-symbol.jpg" style="height:20px;vertical-align: bottom;">)</th>
            </tr>
            <?php $i=0; 
            foreach ($items as $item) {
              if($item['weight'] == 0) {
                // echo 'Naresh';
                $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $item['sku']);
                $item['weight'] = $product->getWeight();
                $order['weight'] += $item['weight'];
              }
              $i++; ?>
              <tr>
                <td valign="top" align="left"><?php echo $i; ?></td>
                <td valign="top" align="left"><?php echo $item['sku'] ?></td>
                <td valign="top" align="left"><?php echo $item['name'] ?></td>
                <td valign="top" align="center"><?php echo $item['weight'] ?></td>
                <td valign="top" align="left"><?php if($item['is_qty_decimal'] == 1){ $count++; echo round($item['qty_ordered'],2); }else{ echo round($item['qty_ordered']); } ?></td>
                <td valign="top" align="left">1.00</td>
                <td valign="top" align="right"><?php echo number_format($item['base_price'],2) ?> </td>
                <td valign="top" align="right"><?php echo number_format($item['qty_ordered']*$item['base_price'],2) ?></td>
              </tr>
            <?php } ?>
            <tr>
              <td valign="top" align="left" colspan="8" style="border-bottom:1px solid #000;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" rowspan="5" align="left" valign="top"><p><span>Sub Total</span> </p>
              <td align="left" valign="top"><?php echo '('.$order['weight'].')'; ?></td>
              <td valign="top" align="left"><?php echo round($order['total_qty_ordered'],2); ?></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top"></td>
              <td align="right" valign="top"><?php echo number_format($order['base_subtotal'],2) ?></td>
            </tr>
            <?php if(ceil($order['discount_amount']) > 0){ ?>
            <tr>
              <td valign="top" align="left" colspan="3">Discount:<br/></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="right" valign="top"><?php echo number_format($order['discount_amount'],2)  ?></td>
            </tr>
            <?php } ?>
            <?php if (isset($order['cod_fee'])) { ?>
            <tr>
              <td valign="top" align="left" colspan="3">COD Charges:<br/></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="right" valign="top"><?php echo number_format($order['cod_fee'],2)  ?></td>
            </tr>
            <?php } ?>
            <?php if(ceil($order['base_shipping_incl_tax']) > 0){ ?>
            <tr>
              <td valign="top" align="left" colspan="3">Shipping & Handling:<br/></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="right" valign="top"><?php echo number_format($order['base_shipping_incl_tax'],2)  ?></td>
            </tr>
            <?php } ?>
            <tr>
              <td valign="top" align="left" colspan="3" class="grand_total"><strong>Grand Total:<br/></strong></td>
              <td align="left" valign="top"  class="grand_total">&nbsp;</td>
              <td align="right" valign="top" class="grand_total"><strong><?php echo number_format($order['base_grand_total'],2)  ?></strong></td>
            </tr>
          </table>
          <div style="margin-left:357px;">(Amount column represents value inclusive of Tax)</div>
        </div>
        <div class="clr"></div><br/><br /><br />
        <div>
          <h1 align="center">TERMS &amp; CONDITIONS</h1>
          <ul class="para">
      <li><span>1.</span><label>Our responsibility ceases immediately after the goods are handed over to the purchaser or his agent, including carriers.</label></li>
    <li><span>2.</span><label>We shall not be responsible for any damage or loss during transit.</label></li>
      <li><span>3.</span><label>Errors and omissions are excepted.</label></li>
      <li><span>4.</span><label>Goods once sold will not be taken back or exchanged.</label></li>  
    <li><span>5.</span><label>All orders confirmed and accepted by the office are always subject to any restrictions or controls now in force or to be introduced hereafter by any Government, Railways or Postal Authorities
.</label></li>
      <li><span>6.</span><label>All engagements are subject to normal force majeure.</label></li>
      <li><span>7.</span><label>If no insurance is effected all risks lie with the buyer in case of loss, damage, pilferage, theft, etc. during transit.</label></li>
      <li><span>8.</span><label>All disputes are subject to Bangalore jurisdiction.</label></li>
      <li><span>9.</span><label>Goods dispatched according to market rates prevailing on the day of the order.  We are not responsible for any fluctuations in prices.</label></li>
    </ul>
  </div>
</div>
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