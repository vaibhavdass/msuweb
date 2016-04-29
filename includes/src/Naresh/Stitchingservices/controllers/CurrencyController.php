<?php
require_once 'Mage/Directory/controllers/CurrencyController.php';
class Naresh_Stitchingservices_CurrencyController extends Mage_Directory_CurrencyController
{
    public function switchAction()
    {
        if ($curency = (string) $this->getRequest()->getParam('currency')) {
        	// Mage::log('Naresh_Stitchingservices_CurrencyController');
            Mage::app()->getStore()->setCurrentCurrencyCode($curency);
            $from = Mage::app()->getStore()->getBaseCurrencyCode();
            $to = $curency;
            $quote1 = Mage::getSingleton('checkout/session')->getQuote();
            $cartItems = $quote1->getAllVisibleItems();
            $newaddaction_collection = Mage::getModel('newaddaction/newaddaction');
            $size = $newaddaction_collection->getCollection()->addFieldToSelect('*')->addFieldToFilter('quote_id',$quote1->getId());
            // Mage::log(sizeof($size),null,'currency.log');
            if (sizeof($cartItems) > 0 && sizeof($size) > 0) {
            	$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
			    $options = array();
			    foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
			        if(strlen($option['label']) > 0){
			            $options[$option['value']] = $option['label'];
			        }
			    }
	            foreach ($cartItems as $item) {
	            	$_product = $item->getProduct();
	            	$db_value = $newaddaction_collection->getCollection()->addFieldToSelect('*')->addFieldToFilter('quote_id',$quote1->getId())->addFieldToFilter('product_id',$item->getProductId())->getFirstItem();
	                if( isset($db_value['service_id']) ){
	                	$model = $newaddaction_collection->load($db_value['service_id']);
	                	$weight = 0;
		                $stitching_cost = 0;
		                $base_stitching_cost = 0;
		                foreach ($options as $key => $value) {
		                    if ($db_value[$key] > 0) {
		                        $stit_service = Mage::getModel('stitchingservices/stitchingservices')->getCollection()->addFieldToSelect('*')->addFieldToFilter('stitching_service_id',$key)->addFieldToFilter('stitchingservices_id',$db_value[$key])->addFieldToFilter('status',1)->getFirstItem();
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
	                	$stitching_cost = 0;
	                }
	                $price = Mage::helper('directory')->currencyConvert($_product->getPrice(), $from, $curency); 
	                $price += $stitching_cost;
	                $item->setOriginalCustomPrice($price);
	                $item->setCustomPrice($price);
	                $item->save();
	                $quote1->collectTotals()->save();
	            }	
            }
        }
        $this->_redirectReferer(Mage::getBaseUrl());
    }
}
