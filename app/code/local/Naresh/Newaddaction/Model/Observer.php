<?php 
	class Naresh_Newaddaction_Model_Observer {
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
	    	Mage::log('arg');
	    	$event = $observer->getEvent();
	    	$quote = Mage::getModel('checkout/session')->getQuote();
	    	$quote_item = $event->getQuoteItem();
        	$new_price = 10;
            $quote_item->setOriginalCustomPrice($new_price);
            $quote_item->setCustomPrice($new_price);
            $quote_item->save();
            $quote->collectTotals()->save();
	    	Mage::log('Product ID : '.$new_price);
			// Mage::log('Naresh : ');
			// $item = $observer->getQuoteItem();
			// $quote = $item->getQuote();
			// Mage::log($item->getData());
			// $event = $observer->getEvent();
			// $quote = Mage::getModel('checkout/session')->getQuote();
			// $quote_item = $event->getQuoteItem();
			// Mage::log($quote_item->getData());
			// // $productId = $quote_item->getId();
			// // $product = Mage::getModel('catalog/product')->load($productId);
			// // $productData = $product->getData();
			// $price = $quote_item->getPrice();
			// $baseprice = $quote_item->getBasePrice();
			// Mage::log('Naresh');
			// Mage::log($price);
			// Mage::log($baseprice);
			// $new_price = 10;
			// $quote_item->setOriginalCustomPrice($price+$new_price);
			// $quote_item->setCustomPrice($baseprice+$new_price);
			// $quote_item->save();
			// $quote->collectTotals()->save();
    	}
    	public function modifyPrice(Varien_Event_Observer $observer) {
            $quote_item = $observer->getQuoteItem(); 
			if ($quote_item->getParentItem()) { 
				$quote_item = $item->getParentItem(); 
			}
			// Mage::log($quote_item->getData());
			// Mage::log($item->getCustomPrice());
			// Mage::log($item->getOriginalPrice());
			$quote_item->setCustomPrice(150);
			$quote_item->setOriginalCustomPrice(150);
			$quote_item->save();
        }
        public function modifyPrice1(Varien_Event_Observer $observer) {
            $quote_item = $observer->getQuoteItem(); 
			if ($quote_item->getParentItem()) { 
				$quote_item = $item->getParentItem(); 
			}
			// Mage::log($quote_item->getData());
			// Mage::log($item->getCustomPrice());
			// Mage::log($item->getOriginalPrice());
			$quote_item->setCustomPrice(250);
			$quote_item->setOriginalCustomPrice(250);
			$quote_item->save();
        }
        protected function _getPriceByItem(Mage_Sales_Model_Quote_Item $item)
        {
            $price;

            return $price;
        }
	}