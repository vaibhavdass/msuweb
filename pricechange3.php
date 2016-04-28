<?php 
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$sku = $_REQUEST['sku'];
	$sku = 3488280;
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
     ->setPageSize(600)
     ->setCurPage(4);
	 // $content = '';
    foreach ($collection as $key => $_prod) {
    	$sku = $_prod->getSku();
	 	$product = Mage::getModel('catalog/product');
		$productId = $product->getIdBySku($sku);
		$product->setStoreId(0)->load($productId);
		if ($product && $product->getId()) {
			$newprice = $product->getPrice();
			echo 'SKU : '.$sku.'<br>';
			$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
			$_product->setStoreId(1)->setPrice($newprice)->save();
			$_product->setStoreId(2)->setPrice($newprice)->save();
			// $content .= $sku;
			// mail('it_magento@mysoresareeudyog.com', 'price edit', $content);
		}
    }