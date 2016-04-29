<?php 
	class Naresh_Stitchingservices_Model_Observer {
		public function addStitchingServices(Varien_Event_Observer $observer) {
			$event = $observer->getEvent();
			$product = $event->getProduct();
			$item = $observer->getQuoteItem();
			if ($item->getParentItem()) {
				$item = $item->getParentItem();
			}
			$id = $item->getQuote()->getId();
			// Mage::log($id);
			// $read = Mage::getSingleton('core/resource')->getConnection('core_read');
			// $write = Mage::getSingleton('core/resource')->getConnection('core_write');
			// $sql = 'SELECT `weight`, `total` FROM `stored_product_stitchingservices` WHERE `quote_id` = '.$id.' AND `product_sku` = '.$product->getSku().' limit 0, 1';
			// $stitchings = $read->fetchAll($sql);
			// $quote_id1 = Mage::getSingleton('checkout/session')->getQuote()->getId();
			// $query1 = "SELECT * FROM sales_flat_quote_item WHERE `quote_id` = ".$quote_id1;
			// Mage::log($query1);
			// $results = $read->fetchAll($query1);
			// Mage::log($results);

			// $sql1 = "SELECT * FROM `sales_flat_quote_item` WHERE `quote_id` = ".$id." AND `sku` = '".$product->getSku()."'";
			// Mage::log($sql1);
			// $stitchings1 = $read->fetchAll($sql1);
			// Mage::log($stitchings1);
			// $quote_item = Mage::getSingleton('sales/quote_item')->load($id);
			// Mage::log($quote_item->getData());
			// Mage::log('Stitchings Cost : '.$stitchings[0]['total']);
			// Mage::log('Stitchings Weight : '.$stitchings[0]['weight']);
			// Mage::log('Row Total : '.$item->getRowTotal());
			// $item->setWeight($weight+$item->getWeight());
			// $item->setRowWeight($weight+$item->getRowWeight());

			// $item->setCustomPrice($stitchings_cost+$item->getCustomPrice());
			// $item->setOriginalCustomPrice($stitchings_cost+$item->getOriginalCustomPrice());
			// $item->setRowTotal($item->getRowTotal()+$stitchings[0]['total']);
			// $item->getProduct()->setIsSuperMode(true);
			// $item->save();
		}
		public function cartProductUpdateAfter(Varien_Event_Observer $observer) {
        	$this->cartProductAddAfter($observer);
    	}

	    public function cartProductAddAfter(Varien_Event_Observer $observer) {
	    	// $product = $observer->getEvent()->getProduct();
	    	// Mage::log($observer->getData());
			// $item = $observer->getQuoteItem();
			// if ($item->getParentItem()) {
			// 	$item = $item->getParentItem();
			// }
	  //   	$item = $observer->getQuoteItem();
			// if ($item->getParentItem()) {
			// 	$item = $item->getParentItem();
			// }
        	// $product = $observer->getEvent()->getProduct();
        	// $currentItem = $observer->getEvent()->getQuoteItem();
        	// $quote = $currentItem->getQuote();
        	// $id = $quote->getId();
        	// Mage::log($item);
        	// $quoteItems = $quote->getItems();

	        /* Detect Product ID and Qty programmatically */
        	// $idToAdd = "ANY PRODUCT ID";
        	// $qty = 1;
        	// $productToAdd = Mage::getModel('catalog/product');
        	//  @var $productToAdd Mage_Catalog_Model_Product 
        	// $productToAdd->load($idToAdd);
        	// $this->_addProductToCart($productToAdd, $qty);
    	}
	}