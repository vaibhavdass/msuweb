<?php 
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$sku = $_REQUEST['sku'];
 	$product = Mage::getModel('catalog/product');
	$productId = $product->getIdBySku($sku);
	$product->setStoreId(0)->load($productId);
	if ($product && $product->getId()) {
		$newprice = $product->getPrice();
		$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
		$_product->setStoreId(1)->setPrice($newprice)->save();
		$_product->setStoreId(2)->setPrice($newprice)->save();
		return 1;
	}else{
		return 0;
	}