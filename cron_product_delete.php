<?php 
	ini_set('memory_limit', "1024M");
	ini_set('max_execution_time', 2400);
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app()->setCurrentStore(0);
	Mage::app();
	Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
	$time = time();
	// echo $time.'<br>';
	$to = date('Y-m-d H:i:s', $time);
	// echo $to.'<br>';
	$lastTime = $time - 2160000; // 60*60*24*25  // 25 Days Back
	$from = date('Y-m-d H:i:s', $lastTime);

	$oldtime = $time - 1814400; // 60*60*24*21 // 21 Days Back
	$old_to = date('Y-m-d H:i:s', $oldtime);

	$order_collection = Mage::getResourceModel('sales/order_item_collection')
							->addAttributeToSelect('order_id')
							->addAttributeToSelect('updated_at')
							->addAttributeToFilter('updated_at', array('from' => $from, 'to' => $to))
							->load();
	echo "SKU's changed to deleted are -<br/>";
	$mail_content = "SKU's changed to deleted are -\n";
	$i = 0;

	foreach ($order_collection as $_order) {
		// echo 'Order ID : '.$_order->getOrderId().'<br>';
		$order = Mage::getModel('sales/order')->load($_order->getOrderId());
		$items = $order->getAllItems();
		// echo sizeof($items).'<br>';
		foreach($items as $i):
			// echo 'Product ID : '.$i->getProductId().'<br>';
			$_product = Mage::getModel('catalog/product')->load($i->getProductId());
			$stocklevel = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product);
			// echo $_product->getUpdatedAt().'<br>';

			if($_product->getUpdatedAt() <= $old_to && $stocklevel->getIsInStock() == 0 && (int)$stocklevel->getQty() < 1){
				echo $_product->getSku()."--";echo $_product->getId()."<br>";
				Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
				$mail_content .= $_product->getSku()."\n";
				Mage::register('isSecureArea', true);
				$_product->delete();
				Mage::unregister('isSecureArea');
				$i++;
			}
		endforeach;
	}
	echo "Records Updated - ".$i;
	$mail_content .= "Records Deleted - ".$i;
	mail('it_magento@mysoresareeudyog.com', 'Cron Job - SKU Removal', $mail_content);
?>