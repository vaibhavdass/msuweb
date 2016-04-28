<?php 
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();

	Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));

	$time = time();
	$to = date('Y-m-d H:i:s', $time);
	$lastTime = $time - 86400; // 60*60*24
	$from = date('Y-m-d H:i:s', $lastTime);
	$order_collection = Mage::getResourceModel('sales/order_item_collection')
	    ->addAttributeToSelect('order_id')
	    ->addAttributeToSelect('created_at')
	    ->addAttributeToFilter('created_at', array('from' => $from, 'to' => $to))
	    ->load();

	echo "SKU's changed to disabled are -<br/>";		
	$mail_content = "SKU's changed to disabled are -\n";
	$i = 0;

	foreach ($order_collection as $_order) {
		// echo 'Order ID : '.$_order->getOrderId().'<br>';
		$order = Mage::getModel('sales/order')->load($_order->getOrderId());
		$items = $order->getAllVisibleItems();
		// echo sizeof($items).'<br>';
		foreach($items as $i):
			// echo 'Product ID : '.$i->getProductId().'<br>';
			$_product = Mage::getModel('catalog/product')->load($i->getProductId());
			$stocklevel = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product);
			if($stocklevel->getIsInStock() == 0 && (int)$stocklevel->getQty() < 1) {
				// echo 'Qty : '.(int)$stocklevel->getQty().'<br>';
				// echo 'Instock : '.$stocklevel->getIsInStock().'<br>';
				// echo 'Backorder : '.$stocklevel->getBackorders().'<br>';
				Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
				$_product->setStatus(2)->save();
				echo $_product->getSku()."<br/>";
				$mail_content .= $_product->getSku()."\n";
				$i++;
			}
		endforeach;
	}

	echo "Records Updated - ".$i;
	$mail_content .= "Records Updated - ".$i;
	mail('it_magento@mysoresareeudyog.com', 'Soldout Cron Job', $mail_content);
?>