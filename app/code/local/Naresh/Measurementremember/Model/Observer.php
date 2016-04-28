<?php 
	class Naresh_Newaddaction_Model_Observer {
	    public function updateProductAfterOrder(Varien_Event_Observer $observer) {
	    	Mage::log('arg');
	    	// $order = $observer->getEvent()->getOrder();
	    	// Mage::log($order->getData());
    	}
	}