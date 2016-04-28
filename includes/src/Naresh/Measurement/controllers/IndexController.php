<?php
class Naresh_Measurement_IndexController extends Mage_Core_Controller_Front_Action
{
	public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();
 
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }
    public function indexAction()
    {
    // 	if ($params = $this->getRequest()->getParams()) {
    // 		$cart = Mage::getSingleton('checkout/cart');
	   //  	$allitems = $cart->getQuote()->getAllItems();
	   //  	$count = 0;
	   //  	if(sizeof($allitems) > 0){
	   //  		foreach ($allitems as $item) {
	   //  			if($item->getProductId() == $params['product_id']) {
	   //  				$count = 1;
	   //  			}
	   //  		}
	   //  	}
	   //  	if ($count == 0 && isset($params['product_id']) && is_null($params['order_id'])) {
	   //  		$_product = Mage::getModel('catalog/product')->load($params['product_id']);
	   //  		$params['qty'] = 1;
		  //   	$item['qty'] = $params['qty'];
		  //   	if (isset($item['qty'])) {
	   //              $filter = new Zend_Filter_LocalizedToNormalized(
	   //                  array('locale' => Mage::app()->getLocale()->getLocaleCode())
	   //              );
	   //              $item['qty'] = $filter->filter($item['qty']);
	   //          }
	   //          $cart->addProduct($_product, $item);
	   //          $cart->save();
				// $quote = Mage::getSingleton('checkout/session')->getQuote();
				// $quote->collectTotals()->save();	
	   //  	}
    // 	}
    	$this->loadLayout( array('default','measurement_index_index'));
		$this->loadLayout();     
		$this->renderLayout();
    }
}