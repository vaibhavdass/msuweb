<?php 
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$collection = Mage::getModel('catalog/product')
     ->getCollection()
     ->addAttributeToSelect('*')
     ->joinField('qty',
                 'cataloginventory/stock_item',
                 'qty',
                 'product_id=entity_id',
                 '{{table}}.stock_id=1',
                 'left')
     ->addAttributeToFilter('qty', array("gt" => 0))
     ->setPageSize(1000)
     ->setCurPage(8);
     echo sizeof($collection);
    foreach ($collection as $key => $_prod) {
    	$sku = $_prod->getSku();
	 	$product = Mage::getModel('catalog/product');
		$productId = $product->getIdBySku($sku);
		$product->setStoreId(0)->load($productId);
		if ($product && $product->getId()) {
			$newprice = $product->getPrice();
			echo 'SKU : '.$sku.'<br>';
			$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
			$newprice1 = $_product->setStoreId(1)->getPrice();
			$newprice2 = $_product->setStoreId(2)->getPrice();
			if($newprice != $newprice1 || $newprice != $newprice2){
				$_product->setStoreId(1)->setPrice($newprice)->save();
				$_product->setStoreId(2)->setPrice($newprice)->save();
			}
		// 	// $content .= $sku;
		// 	// mail('it_magento@mysoresareeudyog.com', 'price edit', $content);
		}
    }