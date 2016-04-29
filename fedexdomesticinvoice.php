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
  $order_id=$invoice['order_id'];
  $order=Mage::getModel('sales/order')->load($order_id);
	// $order->setData('state', "complete");
	// $order->setStatus("complete");
	// $history = $order->addStatusHistoryComment('Order Status changed to Shipped.', false);
	// $history->setIsCustomerNotified(false);
	// $order->save();
  $shipping=$order->getShippingAddress()->getData();      
  $cusnameship=$shipping['firstname']." ".$shipping['lastname'];
  $companyship=$shipping['company']; 
  $streetship=$shipping['street'];
  $regionship=$shipping['city'].", ".$shipping['region'].", ".$shipping['postcode'];
  $countryship=$shipping['country_id'];
  $telephoneship=$shipping['telephone'];
  ?>
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Domestic Invoice</title>
      <style type="text/css">
        body{font:normal 12px Arial; color:#000; text-align:left;}
        .main-wrapper{border: 3px solid; margin: 0 auto; width: 651px;padding:10px 10px 50px}
        .shipping_address, .from_address{font-size:20px;padding: 5px 10px;}
        .lft-div{float: left; height: 90px; width: 63%;}
        .shipping_address > h1 {padding-top: 50px;}
        .order_no {float: right;font-size: 18px;font-weight: bold;height: 30px;padding: 10px 0% 10px 0;text-align: right;vertical-align: middle;width: 37%;}
      </style>
    </head>
    <body>
      <div class="main-wrapper">
        <div class="header">
        <div class="lft-div">
          <span><img src="/skin/frontend/default/default/images/logo_email.gif" /></span>
        </div>
        <div class="order_no">Order : <?php echo $order->getRealOrderId(); ?></div>
        <div class="shipping_address">
          <br><br>
            <h1>To</h1>
            <div><?php echo strtoupper($cusnameship).'<br />'.strtoupper($companyship).'<br/>'.strtoupper($streetship).'<br/>'.strtoupper($regionship).'<br/>'.strtoupper($countryship).'<br/>'.$telephoneship.'<br/>'; ?></div>
        </div>
        <br><br>
        <div class="from_address">
            <h1>From</h1>
            <div><b>MYSORE SAREE UDYOG LLP</b><br/>10/A, 2nd Floor,<br/> ChandraKiran Building, <br>Kasturba Road, <br/>Bangalore 560001<br/>Ph : +91 8722 8023 03/17<br/></div>
        </div>
      </div>
    </body>
  </html>