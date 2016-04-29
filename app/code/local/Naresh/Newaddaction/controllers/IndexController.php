<?php
class Naresh_Newaddaction_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		// $this->loadLayout();     
		// $this->renderLayout();
        $block = $this->getLayout()->createBlock('newaddaction/newaddaction')->setTemplate('newaddaction/newaddaction.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getStitchingsAction()
    {
        $block = $this->getLayout()->createBlock('newaddaction/newaddaction')->setTemplate('newaddaction/getstitchings.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function addtocartAction() {
        $params = $this->getRequest()->getParams();
        $_product = Mage::getModel('catalog/product')->load($params['id']);
        $cart = Mage::getSingleton('checkout/cart');
        $item['qty'] = $params['qty'];
        if (isset($item['qty'])) {
            $filter = new Zend_Filter_LocalizedToNormalized(
                array('locale' => Mage::app()->getLocale()->getLocaleCode())
            );
            $item['qty'] = $filter->filter($item['qty']);
        }
        $cart->addProduct($_product, $item);
        $cart->save();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $quote->collectTotals()->save();


        $cart_sidebar_header = Mage::app()->getLayout()->createBlock('newaddaction/newaddaction')->setTemplate('checkout/cart/mini.phtml')->toHtml();
        $result['top_cart'] =  $cart_sidebar_header;

        echo json_encode($result);
    }
    public function addAction()
    {
    	$params = $this->getRequest()->getParams();
        $cart = Mage::getSingleton('checkout/cart');
        $allitems = $cart->getQuote()->getAllItems();
        $count = 0;
        if(sizeof($allitems) > 0){
            foreach ($allitems as $item) {
                if($item->getProductId() == $params['product_id']) {
                    $count = 1;
                }
            }
        }
        if ($count == 0 && isset($params['product_id'])) {
            $_product = Mage::getModel('catalog/product')->load($params['product_id']);
            $params['qty'] = 1;
            $item['qty'] = $params['qty'];
            if (isset($item['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $item['qty'] = $filter->filter($item['qty']);
            }
            $cart->addProduct($_product, $item);
            $cart->save();
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $quote->collectTotals()->save();    
        }


        $quote1 = Mage::getSingleton('checkout/session')->getQuote();
        $data['quote_id'] = $quote1->getId();
        $data['product_id'] = $params['product_id'];
        $from = Mage::app()->getStore()->getBaseCurrencyCode();
        $to = Mage::app()->getStore()->getCurrentCurrencyCode();
        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
        $options = array();
        foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
            if(strlen($option['label']) > 0){
                $options[$option['value']] = $option['label'];
            }
        }

        $newaddaction_collection = Mage::getModel('newaddaction/newaddaction');
        $db_value = $newaddaction_collection->getCollection()->addFieldToSelect('service_id')->addFieldToFilter('quote_id',$data['quote_id'])->addFieldToFilter('product_id',$data['product_id'])->getFirstItem();
        if ($params['stitching_services'] == 'with_stitching') {
            if( isset($db_value['service_id']) ){
                $model = $newaddaction_collection->load($db_value['service_id']);
                $weight = 0;
                $stitching_cost = 0;
                $base_stitching_cost = 0;
                foreach ($options as $key => $value) {
                    if (isset($params['stitchingservices'][$key])) {
                        $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$params['stitchingservices'][$key])->addFieldToFilter('status',1)->getFirstItem();
                        if (sizeof($stit_service) > 0) {
                            $weight += $stit_service['weight'];
                            $base_stitching_cost += $stit_service['stitching_service_price'];
                            $stit_price = 0;
                            $stit_price = Mage::helper('directory')->currencyConvert($stit_service['stitching_service_price'], $from, $to);
                            $stitching_cost += $stit_price;
                            $model->{'set' . $key}($params['stitchingservices'][$key]);
                            $model->{'set' . $key . 'Price'}($stit_price);
                        }
                    } else{
                        $model->{'set' . $key}(0);
                        $model->{'set' . $key . 'Price'}(0);
                    }
                }
                $model->setBaseCurrency($from);
                $model->setCurrentCurrency($to);
                $model->setWeight($weight);
                $model->setTotal($stitching_cost);
                $model->setBaseTotal($base_stitching_cost);
                $model->save();
            } else{
                $weight = 0;
                $stitching_cost = 0;
                $base_stitching_cost = 0;
                foreach ($options as $key => $value) {
                    if (isset($params['stitchingservices'][$key])) {
                        $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$params['stitchingservices'][$key])->addFieldToFilter('status',1)->getFirstItem();
                        if (sizeof($stit_service) > 0) {
                            $weight += $stit_service['weight'];
                            $base_stitching_cost += $stit_service['stitching_service_price'];
                            $stit_price = 0;
                            $stit_price = Mage::helper('directory')->currencyConvert($stit_service['stitching_service_price'], $from, $to);
                            $stitching_cost += $stit_price;
                            $data[$key] = $params['stitchingservices'][$key];
                            $data[$key.'_price'] = $stit_price;
                        }
                    }
                }
                $data['base_currency'] = $from;
                $data['current_currency'] = $to;
                $data['weight'] = $weight;
                $data['base_total'] = $base_stitching_cost;
                $data['total'] = $stitching_cost;
                $newaddaction_collection->setData($data)->save();
            }
        }else{
            $stitching_cost = 0;
            if( isset($db_value['service_id']) ){
                Mage::getModel('newaddaction/newaddaction')->load($db_value['service_id'])->delete();
            }
        }
        $cartItems = $quote1->getAllVisibleItems();
        foreach ($cartItems as $item) {
            if ($params['product_id'] == $item->getProductId()) {
                $_product = $item->getProduct();
                $price = Mage::helper('directory')->currencyConvert($_product->getFinalPrice(), $from, $to); 
                $price += $stitching_cost;
                $item->setOriginalCustomPrice($price);
                $item->setCustomPrice($price);
                $item->save();
                $quote1->collectTotals()->save();
            }
        }
        // $this->_redirect('checkout/cart');
        $this->_redirectReferer(Mage::getUrl('*/*'));
    }
    public function storeAction()
    {
        $params = $this->getRequest()->getParams();
        $cart = Mage::getSingleton('checkout/cart');
        $allitems = $cart->getQuote()->getAllItems();
        $count = 0;
        if(sizeof($allitems) > 0){
            foreach ($allitems as $item) {
                if($item->getProductId() == $params['product_id']) {
                    $count = 1;
                }
            }
        }
        if ($count == 0 && isset($params['product_id'])) {
            $_product = Mage::getModel('catalog/product')->load($params['product_id']);
            $params['qty'] = 1;
            $item['qty'] = $params['qty'];
            if (isset($item['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $item['qty'] = $filter->filter($item['qty']);
            }
            $cart->addProduct($_product, $item);
            $cart->save();
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $quote->collectTotals()->save();    
        }


        $quote1 = Mage::getSingleton('checkout/session')->getQuote();
        $data['quote_id'] = $quote1->getId();
        $data['product_id'] = $params['product_id'];
        $from = Mage::app()->getStore()->getBaseCurrencyCode();
        $to = Mage::app()->getStore()->getCurrentCurrencyCode();
        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
        $options = array();
        foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
            if(strlen($option['label']) > 0){
                $options[$option['value']] = $option['label'];
            }
        }

        $newaddaction_collection = Mage::getModel('newaddaction/newaddaction');
        $db_value = $newaddaction_collection->getCollection()->addFieldToSelect('service_id')->addFieldToFilter('quote_id',$data['quote_id'])->addFieldToFilter('product_id',$data['product_id'])->getFirstItem();
        if ($params['stitching_services'] == 'with_stitching') {
            if( isset($db_value['service_id']) ){
                $model = $newaddaction_collection->load($db_value['service_id']);
                $weight = 0;
                $stitching_cost = 0;
                $base_stitching_cost = 0;
                foreach ($options as $key => $value) {
                    if (isset($params['stitchingservices'][$key])) {
                        $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$params['stitchingservices'][$key])->addFieldToFilter('status',1)->getFirstItem();
                        if (sizeof($stit_service) > 0) {
                            $weight += $stit_service['weight'];
                            $base_stitching_cost += $stit_service['stitching_service_price'];
                            $stit_price = 0;
                            $stit_price = Mage::helper('directory')->currencyConvert($stit_service['stitching_service_price'], $from, $to);
                            $stitching_cost += $stit_price;
                            $model->{'set' . $key}($params['stitchingservices'][$key]);
                            $model->{'set' . $key . 'Price'}($stit_price);
                        }
                    } else{
                        $model->{'set' . $key}(0);
                        $model->{'set' . $key . 'Price'}(0);
                    }
                }
                $model->setBaseCurrency($from);
                $model->setCurrentCurrency($to);
                $model->setWeight($weight);
                $model->setTotal($stitching_cost);
                $model->setBaseTotal($base_stitching_cost);
                $model->save();
            } else{
                $weight = 0;
                $stitching_cost = 0;
                $base_stitching_cost = 0;
                foreach ($options as $key => $value) {
                    if (isset($params['stitchingservices'][$key])) {
                        $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$params['stitchingservices'][$key])->addFieldToFilter('status',1)->getFirstItem();
                        if (sizeof($stit_service) > 0) {
                            $weight += $stit_service['weight'];
                            $base_stitching_cost += $stit_service['stitching_service_price'];
                            $stit_price = 0;
                            $stit_price = Mage::helper('directory')->currencyConvert($stit_service['stitching_service_price'], $from, $to);
                            $stitching_cost += $stit_price;
                            $data[$key] = $params['stitchingservices'][$key];
                            $data[$key.'_price'] = $stit_price;
                        }
                    }
                }
                $data['base_currency'] = $from;
                $data['current_currency'] = $to;
                $data['weight'] = $weight;
                $data['base_total'] = $base_stitching_cost;
                $data['total'] = $stitching_cost;
                $newaddaction_collection->setData($data)->save();
            }
        }else{
            $stitching_cost = 0;
            if( isset($db_value['service_id']) ){
                Mage::getModel('newaddaction/newaddaction')->load($db_value['service_id'])->delete();
            }
        }
        $cartItems = $quote1->getAllVisibleItems();
        foreach ($cartItems as $item) {
            if ($params['product_id'] == $item->getProductId()) {
                $_product = $item->getProduct();
                $price = Mage::helper('directory')->currencyConvert($_product->getPrice(), $from, $to); 
                $price += $stitching_cost;
                $item->setOriginalCustomPrice($price);
                $item->setCustomPrice($price);
                $item->save();
                $quote1->collectTotals()->save();
            }
        }
        $this->_redirectReferer(Mage::getUrl('*/*'));
    }
    public function removeAction(){
        $params = $this->getRequest()->getParams();
        $from = Mage::app()->getStore()->getBaseCurrencyCode();
        $to = Mage::app()->getStore()->getCurrentCurrencyCode();
        $quote1 = Mage::getSingleton('checkout/session')->getQuote();
        $model = Mage::getModel('newaddaction/newaddaction')->load($params['service_id']);
        $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
        $options = array();
        foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
            if(strlen($option['label']) > 0){
                $options[$option['value']] = $option['label'];
            }
        }
        $weight = 0;
        $stitching_cost = 0;
        $base_stitching_cost = 0;
        foreach ($options as $key => $value) {
            if ($params['stitching_service'] == $key) {
                $model->{'set' . $key}(0);
                $model->{'set' . $key . 'Price'}(0);
            }else if($model->{'get' . $key}() > 0){
                $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$model->{'get' . $key}())->addFieldToFilter('status',1)->getFirstItem();
                if (sizeof($stit_service) > 0) {
                    $weight += $stit_service['weight'];
                    $base_stitching_cost += $stit_service['stitching_service_price'];
                    $stit_price = 0;
                    $stit_price = Mage::helper('directory')->currencyConvert($stit_service['stitching_service_price'], $from, $to);
                    $stitching_cost += $stit_price;
                    $model->{'set' . $key}($params['stitchingservices'][$key]);
                    $model->{'set' . $key . 'Price'}($stit_price);
                }
            }
        }
        $model->setBaseCurrency($from);
        $model->setCurrentCurrency($to);
        $model->setWeight($weight);
        $model->setTotal($stitching_cost);
        $model->setBaseTotal($base_stitching_cost);
        $model->save();
        $cartItems = $quote1->getAllVisibleItems();
        foreach ($cartItems as $item) {
            if ($params['product_id'] == $item->getProductId()) {
                $_product = $item->getProduct();
                $price = Mage::helper('directory')->currencyConvert($_product->getPrice(), $from, $to); 
                $price += $stitching_cost;
                $item->setOriginalCustomPrice($price);
                $item->setCustomPrice($price);
                $item->save();
                $quote1->collectTotals()->save();
            }
        }
        $this->_redirect('checkout/cart');
    }
}