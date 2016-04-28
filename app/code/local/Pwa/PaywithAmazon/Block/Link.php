<?php

/**
 * This file is part of The Official Amazon Payments Magento Extension
 * (c) Pay with Amazon
 * All rights reserved
 *
 * Reuse or modification of this source code is not allowed
 * without written permission from Pay with Amazon
 *
 * @category   Pwa
 * @package    Pwa_PaywithAmazon
 * @copyright  Copyright (c) Pay with Amazon
 * @author     Pay with Amazon
 */
class Pwa_PaywithAmazon_Block_Link extends Pwa_PaywithAmazon_Block_Abstract {

    public function _toHtml() {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if ($this->_isActive() && $quote->validateMinimumAmount()) {
            return parent::_toHtml();
        }
        return '';
    }
    protected function _getGlobalSettingGLCategory() {
        return Mage::getStoreConfig(self::XML_PATH_GLOBAL_EDD_CATEGORY);
    }
    protected function _getGlobalSettingHazmat() {
        return Mage::getStoreConfig(self::XML_PATH_GLOBAL_EDD_HAZMAT);
    }
    protected function _getGlobalSettingHandlingTimeMin() {
        return Mage::getStoreConfig(self::XML_PATH_GLOBAL_HANDLING_TIME_MIN);
    }
    protected function _getGlobalSettingHandlingTimeMax() {
        return Mage::getStoreConfig(self::XML_PATH_GLOBAL_HANDLING_TIME_MAX);
    }

    protected function _getButtonSize() {
        return Mage::getStoreConfig(self::XML_PATH_BUTTON_SIZE);
    }

    protected function _getButtonColor() {
        return Mage::getStoreConfig(self::XML_PATH_BUTTON_COLOR);
    }

    protected function _getButtonBackground() {
        return Mage::getStoreConfig(self::XML_PATH_BUTTON_BACKGROUND);
    }

    public function getButtonWidgetUrl() {
        switch ($this->_getMarketplace()) {
            case 'de_DE':
                switch ($this->_getMode()) {
                    case 'live':
                        return 'https://payments.amazon.de/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';

                    case 'sandbox':
                        return 'https://payments-sandbox.amazon.de/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';
                }

            case 'en_GB':
                switch ($this->_getMode()) {
                    case 'live':
                        return 'https://payments.amazon.co.uk/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';

                    case 'sandbox':
                        return 'https://payments-sandbox.amazon.co.uk/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';
                }
            case 'hi_IN':
                switch ($this->_getMode()) {
                    case 'live':
                        return 'https://paywithamazon.amazon.in/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';

                    case 'sandbox':
                        return 'https://paywithamazon-sandbox.amazon.in/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';
                }
                break;

            default:
                switch ($this->_getMode()) {
                    case 'live':
                        return 'https://payments.amazon.com/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';

                    case 'sandbox':
                        return 'https://payments-sandbox.amazon.com/gp/cba/button?cartOwnerId=' . $this->getMerchantId() . '&size=' . $this->_getButtonSize() . '&color=' . $this->_getButtonColor() . '&background=' . $this->_getButtonBackground() . '&type=inlineCheckout';
                }
        }

    }

    public function getAmazonCheckoutUrl() {
        $url = Mage::getUrl('paywithamazon/checkout');
/*
        if (preg_match('/\?(.+)/', $url))
            $url .= '&purchaseContractId=';
            $url .= '?purchaseContractId=';
 */
        return $url;
    }

    public function getPurchaseContractId() {
        if (Mage::getStoreConfig(self::XML_PATH_REUSE_AMAZON_SESSION)) {
            if (Mage::getSingleton('checkout/session')->getAmazonPurchaseContractId()) {
                try {
                    $purchaseContract = Mage::getModel('paywithamazon/api_checkout')->getPurchaseContract(Mage::getSingleton('checkout/session')->getAmazonPurchaseContractId());
                    if (strtolower($purchaseContract->getState()) == 'active') return $purchaseContract->getId();
                } catch (Exception $e) {
                    return false;
                }
            }
        }
        return false;
    }
    
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }
    
    public function getShippableItems()
    {
        $items = array();
        foreach ($this->_getQuote()->getItemsCollection() as $item) {
            $productType = $item->getProduct()->getTypeID();
            if (!$item->isDeleted() && !$item->getParentItemId() && $productType != Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL && $productType != Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE) {
                $items[] =  $item;
            }
        }
        return $items;
    }
    
    protected function _getOptionList($item)
    {
        $type = $item->getProduct()->getTypeID();
        $configHelper = Mage::helper('catalog/product_configuration');
        $bundleHelper = Mage::helper('bundle/catalog_product_configuration');
        if($type == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE){
            $test = $item->getProduct()->getTypeInstance(true)->getConfigurableAttributesAsArray($item->getProduct());
            return $configHelper->getConfigurableOptions($item);
        }
        elseif($type == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
            return $bundleHelper->getOptions($item);
        }
        else{
            return $configHelper->getCustomOptions($item);
        }
    }
    public function createOrderInputValue()
    {

        $accessKeyId=Mage::helper('paywithamazon')->getConfigData('access_key_id');
        $dom = new DOMDocument("1.0","utf-8");
        $dom->formatOutput = true;
        $orderXML = $dom->saveXML($this->toXML($dom));
        //Mage::log($orderXML, 4, 'xmlsx-res.log',1);
        $encodedCart = $this->encodeCart($orderXML);
        /* $quoteId = Mage::getSingleton('checkout/session')->getQuote()->getId();
        Mage::getModel('paywithamazon/log_xml')->addXml($encodedCart, $quoteId); */
        $orderInput = "type:merchant-signed-order/aws-accesskey/1;order:".$encodedCart.";"."signature:".$this->signCart($orderXML) .";aws-access-key-id:". $accessKeyId;
        return $orderInput;
    }

    public function toXML($dom)
    {
        $merchantId=Mage::helper('paywithamazon')->getConfigData('merchant_id');
        $orderXML = $dom->createElement("Order");
        $orderXML->setAttribute("xmlns","http://payments.amazon.com/checkout/2009-05-15/");
        //Arrays for item Shipping Tables and Promotions
        $itemShippingMethods = array();
        $itemPromotions = array();
        $cart = $dom->createElement("Cart");
        $itemsTag = $dom->createElement("Items");       
        $quote = $this->_getQuote();
        //Remove Non-Shippable product
        $getCartItems = $this->getShippableItems();
        $easy_weight = 0;
        if(Mage::helper('paywithamazon')->getEasyShipStatus())
        {
            $easy_weight = $this->easyhsip_weight_check();

        }
        foreach ($getCartItems as $item)
        {
            //$options = $this->_getOptionList($item);
            $itemsTag->appendChild($dom->importNode($this->toitemXML($merchantId,"INR","g",$dom,$item,$easy_weight),true));
        }
        $cart->appendChild($itemsTag);
        $totals =  $quote->getTotals(); 
        if(isset($totals['discount']) && $totals['discount']->getValue()) {
                $discount = $totals["discount"]->getValue();
                $discount = abs($totals["discount"]->getValue());
        }
        if(!Mage::getStoreConfig('tax/calculation/price_includes_tax'))
        {
            $discount_diff = $this->calculateDiscountDiff();
            $discount += $discount_diff;
        }
        $coupancode=$quote->getCouponCode();
        if(isset($totals['discount']))
        {
            $promotions = $dom->createElement("Promotions");
            $cart->appendChild($dom->createElement("CartPromotionId",$coupancode));
            $orderXML->appendChild($cart);
            $promotions->appendChild($dom->importNode($this->topromotionXML($merchantId,$discount,$coupancode,$dom),true));
            $orderXML->appendChild($promotions);
        }else
        {
            $orderXML->appendChild($cart);
        }
        //Save the cart xml in our table
        $quoteId = Mage::getSingleton('checkout/session')->getQuote()->getId();
        $cartXmlID = Mage::getModel('paywithamazon/log_xml')->addXml($this->encodeCart($dom->saveXML($orderXML)), $quoteId);
        
        $cartDetails = serialize(array('cart_id' => $cartXmlID, 'store_id' => Mage::app()->getStore()->getId()));
        $cartCustomData = $dom->createElement("CartCustomData");
        $cartDetailsTag = $dom->createElement('cartDetails', $cartDetails);
        $cartCustomData->appendChild($dom->importNode($cartDetailsTag));
        $cart->appendChild($cartCustomData);
        
        $returnUrl = $this->getUrl('paywithamazon/process/processamzoneorder',
                                    array(
                                        'cart_id' => $cartXmlID, 'store_id' => Mage::app()->getStore()->getId(),
                                        '_secure' => true
                                    ));
        
        if(Mage::getStoreConfig('paywithamazon/amazon_shipping_option/enable_shipping_override'))
            $orderXML->appendChild($dom->importNode($this->toshippinmethods($dom),true));

        $orderXML->appendChild($dom->createElement("IntegratorId",""));
        $orderXML->appendChild($dom->createElement("IntegratorName","standard checkout"));
        $orderXML->appendChild($dom->createElement("ReturnUrl",$returnUrl));
        $orderXML->appendChild($dom->createElement("CancelUrl",$this->getUrl('checkout/cart', array('_secure' => true))));
        $callbacksTag = $dom->createElement("OrderCalculationCallbacks");
        $callbacksTag->appendChild($dom->createElement("CalculatePromotions","false"));
        $callbacksTag->appendChild($dom->createElement("CalculateShippingRates","false"));
        $callbacksTag->appendChild($dom->createElement("OrderCallbackEndpoint",$this->getBaseUrl()."checkout/cart"));
        $callbacksTag->appendChild($dom->createElement("ProcessOrderOnCallbackFailure","false"));
        $orderXML->appendChild($callbacksTag);
        return $orderXML;
    }

    public function encodeCart($orderXML)
    {
        return base64_encode($orderXML);
    }
    public function signCart($orderXML)
    {
        $secretkey=Mage::getStoreConfig('paywithamazon/general/secret_key');
        return $this->calculateRFC2104HMAC($orderXML, $secretkey);
    }

    public function calculateRFC2104HMAC($data, $key) 
    {
        // compute the hmac on input data bytes, make sure to set returning raw hmac to be true
        $HMAC_SHA1_ALGORITHM = "sha1";
        $rawHmac = hash_hmac($HMAC_SHA1_ALGORITHM, $data, $key, true);
        return base64_encode($rawHmac);
    }
    public function toitemXML($merchantId,$currency,$weightunit,$dom,$item,$easy_weight)
    {
        $price = $this->helper('checkout')->getPriceInclTax($item);

	$easyship_weight_unit = Mage::getStoreConfig('paywithamazon/general/easyship_weight');
	$weight = $item->getWeight();

	if($easyship_weight_unit=="gram") 
		
		$weight= $weight/1000; 

 
        $item_id = $item->getId();
        $sku = $item_id.'_'.$item->getData('sku');
        $itemXML = $dom->createElement("Item");
    
        $sku = substr($sku,0,40);
        $title=$this->getProductName($item);
        $title=substr($title,0,80);


    	$itemXML = $dom->createElement("Item");
        $itemXML->appendChild($dom->createElement("SKU",htmlspecialchars($sku) ));
         
        $itemXML->appendChild($dom->createElement("MerchantId",$merchantId));
        
        $itemXML->appendChild($dom->createElement("Title",$item->getQty()._.htmlspecialchars($this->getProductName($item)  )));
        $itemXML->appendChild($dom->createElement("Description",htmlspecialchars($this->getProductName($item))));
        
        $price=$price*$item->getQty();

        $itemXML->appendChild($dom->importNode($this->topriceXML($price,$dom),true));        
        $itemXML->appendChild($dom->createElement("Quantity", "1") );
        
        if($weight>0){
            $itemXML->appendChild($dom->importNode($this->towightXML($weight,$dom),true)); 
        }
        $product_id=$item->getProductId();
        $product=Mage::getModel('catalog/product')->load($product_id)->getData();
     

        if(Mage::helper('paywithamazon')->getEasyShipStatus() && $easy_weight <= 9){
            
            $easy_aws_gil = isset($product['easy_aws_gil']) ? $product['easy_aws_gil'] : null ;
            // Global Settings for GL Category
            if($easy_aws_gil=="" || $easy_aws_gil==null )
                $easy_aws_gil=$this->_getGlobalSettingGLCategory();

            $easy_aws_hazmat = isset($product['easy_aws_hazmat']) ? $product['easy_aws_hazmat'] : 0 ; 
            // Global Settings for Hazmat
            if(!($easy_aws_hazmat===1 || $easy_aws_hazmat===0))
                $easy_aws_hazmat=$this->_getGlobalSettingHazmat();

            $hazmat = $easy_aws_hazmat ? 'true' : 'false';
             
            $easy_aws=array();
            $easy_aws['easy_aws_length'] = isset($product['easy_aws_length']) ? $product['easy_aws_length'] : 0; 
            $easy_aws['easy_aws_width'] = isset($product['easy_aws_width']) ? $product['easy_aws_width'] : 0; 
            $easy_aws['easy_aws_height'] = isset($product['easy_aws_height']) ? $product['easy_aws_height'] : 0; 

            if($easy_aws['easy_aws_height'] >0 && $easy_aws['easy_aws_width'] >0 && $easy_aws['easy_aws_length']>0)

            $itemXML->appendChild($dom->importNode($this->toitemdimensionXML($dom,$item,$easy_aws),true));

            $category = $dom->createElement("Category");
            $category->appendChild($dom->createCDATASection($easy_aws_gil));
            $itemXML->appendChild($dom->importNode($category));

            $itemXML->appendChild($dom->createElement("Hazmat", $hazmat));
        }
        if(Mage::getStoreConfig('paywithamazon/amazon_shipping_option/enable_shipping_override')){
            $this->getallshippingmethods($dom,$itemXML);
        }

        if(Mage::helper('paywithamazon')->getAwsActiveStatus()){
          $easy_aws_hand_max = isset($product['easy_aws_hand_max']) ? $product['easy_aws_hand_max'] : 0 ; 

          $easy_aws_hand_min = isset($product['easy_aws_hand_min']) ? $product['easy_aws_hand_min'] : 0 ; 

            // Pick Global Configuration If Product level values are not found
            if(!($easy_aws_hand_min > 0 && $easy_aws_hand_max > 0)){
                $easy_aws_hand_min=$this->_getGlobalSettingHandlingTimeMin();
                $easy_aws_hand_max=$this->_getGlobalSettingHandlingTimeMax();
            }

            if($easy_aws_hand_min > 0 && $easy_aws_hand_max > 0){
            $itemHandling = $itemXML->appendChild($dom->createElement("HandlingTime"));
            $itemHandling->appendChild($dom->createElement("MinDays", $easy_aws_hand_min));
            $itemHandling->appendChild($dom->createElement("MaxDays", $easy_aws_hand_max));
            }
        } 
        $itemXML->appendChild($dom->importNode($this->addProductParams($dom, $item)));
        return $itemXML;
    }
    
    public function getallshippingmethods($dom,$itemXML)
    {
        $shipping_methods = unserialize(Mage::getStoreConfig('paywithamazon/amazon_shipping_option/international_shipping_method'));
        $itemShippingIds = $itemXML->appendChild($dom->createElement("ShippingMethodIds"));
        $i = 1;
        foreach ($shipping_methods['shipping_label'] as $key => $value) {
            if($key == 0)
                continue;
            $shipping_method_id = 'shipping_id'.$i;
            $itemShippingIds->appendChild($dom->createElement("ShippingMethodId",$shipping_method_id));
            $i++;
        }
    }

    public function toshippinmethods($dom)
    {
        $shipping_methods = unserialize(Mage::getStoreConfig('paywithamazon/amazon_shipping_option/international_shipping_method'));
        $slo = array();
        
        foreach ($shipping_methods as $key => $shipping_method) {
            foreach ($shipping_method as $key_tag => $value) {
                if($key_tag == 0) continue;
                $slo[$key_tag][$key] = $value;
            }
        }
        $i = 1;
        $itemshipments = $dom->createElement("ShippingMethods");
        foreach ($slo as $key => $ship_method) {
            $service_level = $ship_method['service_level'];
            $shipping_rate = $ship_method['shipping_rate'];
            
            if($shipping_rate == '' || $service_level == '') continue;

            $shipping_price = $ship_method['shipping_price'];
            $price = $ship_method['price'];
            $shipping_mindays = $ship_method['delivery_time_minimum'];
            $shipping_maxdays = $ship_method['delivery_time_maximum'];
            $shipping_id = 'shipping_id'.$i;
            $shipping_label = (isset($ship_method['shipping_label']) && $ship_method['shipping_label'] != '') ? $ship_method['shipping_label'] : ''; 
            $i++;

            $itemshipment = $itemshipments->appendChild($dom->createElement("ShippingMethod"));
            $itemshipment->appendChild($dom->createElement("ShippingMethodId",$shipping_id));
            $itemshipment->appendChild($dom->createElement("ServiceLevel",$service_level));
            $itemshipmentrate = $itemshipment->appendChild($dom->createElement("Rate"));
            
                if($shipping_rate == 'ItemQuantityBased+ShipmentBased' || $shipping_rate == 'WeightBased+ShipmentBased')
                {
                    $shipping_rate_data = explode('+', $shipping_rate);
                    $itemshipmentratequantity = $itemshipmentrate->appendChild($dom->createElement(trim($shipping_rate_data[0])));
                    $itemshipmentratequantity->appendChild($dom->createElement("Amount",$price));
                    $itemshipmentratequantity->appendChild($dom->createElement("CurrencyCode",'INR'));
                    $itemshipmentratequantity1 = $itemshipmentrate->appendChild($dom->createElement(trim($shipping_rate_data[1])));
                    $itemshipmentratequantity1->appendChild($dom->createElement("Amount",$shipping_price));
                    $itemshipmentratequantity1->appendChild($dom->createElement("CurrencyCode",'INR'));
                }
                else
                {   
                    $itemshipmentratequantity = $itemshipmentrate->appendChild($dom->createElement($shipping_rate));
                    $itemshipmentratequantity->appendChild($dom->createElement("Amount",$price));
                    $itemshipmentratequantity->appendChild($dom->createElement("CurrencyCode",'INR'));
                }
             
            if(isset($ship_method['included_region']) && $ship_method['included_region']!='')
            {
                $itemshipmentregion = $itemshipment->appendChild($dom->createElement("IncludedRegions"));
                if($ship_method['included_region']=='WORLDALL')
                    $itemshipmentpredefined = $itemshipmentregion->appendChild($dom->createElement("PredefinedRegion",'WorldAll'));
                else
                {
                    $itemshipmentregionworld = $itemshipmentregion->appendChild($dom->createElement("WorldRegion"));
                    $itemshipmentregionworld->appendChild($dom->createElement("CountryCode",$ship_method['included_region']));
                }
            }
            if($ship_method['included_region']=='WORLDALL'){
                if(isset($ship_method['excluded_region']) && $ship_method['excluded_region']!='')
                {
                    $itemshipmentregion = $itemshipment->appendChild($dom->createElement("ExcludedRegions"));
                    if($ship_method['excluded_region']=='WORLDALL')
                        $itemshipmentpredefined = $itemshipmentregion->appendChild($dom->createElement("PredefinedRegion",'WorldAll'));
                    else
                    {
                        $itemshipmentregionworld = $itemshipmentregion->appendChild($dom->createElement("WorldRegion"));
                        $itemshipmentregionworld->appendChild($dom->createElement("CountryCode",$ship_method['excluded_region']));
                    }
                }
            }    
            if($shipping_mindays > 0 && $shipping_maxdays > 0){
                $itemshipmentdelivery = $itemshipment->appendChild($dom->createElement("DeliveryTime"));
                $itemshipmentdelivery->appendChild($dom->createElement("MinDays",$shipping_mindays));
                $itemshipmentdelivery->appendChild($dom->createElement("MaxDays",$shipping_maxdays));
            }
            $itemshipment->appendChild($dom->createElement("DisplayableShippingLabel",$shipping_label));
        }
        return $itemshipments;
    }
    
    public function getProductName($item)
    {
        if($item->hasData('product_name')){
            return $item->getData('product_name');
        }
        return $item->getProduct()->getName();
    }
    public function addProductParams($dom, $item)
    {   
        $customTag = $dom->createElement('ItemCustomData');
        $orderOptions = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        $param = array();
        $param['product'] = $item->getProductId();
        $param['qty'] = $item->getQty();
        $param['info_buyRequest'] = isset($orderOptions['info_buyRequest']) ? $orderOptions['info_buyRequest'] : '';
        $param['options'] = isset($orderOptions['info_buyRequest']['options']) ? $orderOptions['info_buyRequest']['options'] : '';
        $param['bundle_option'] = isset($orderOptions['info_buyRequest']['bundle_option'])? $orderOptions['info_buyRequest']['bundle_option'] : '';
        $param['bundle_option_qty'] = isset($orderOptions['info_buyRequest']['bundle_option_qty'])? $orderOptions['info_buyRequest']['bundle_option_qty'] : '';
        $param['super_product_config'] = isset($orderOptions['info_buyRequest']['super_product_config'])?$orderOptions['info_buyRequest']['super_product_config'] : '';
        $productParamsTag = $dom->createElement('ProductParams');
        $productParamsTag->appendChild($dom->createCDATASection(serialize(array_filter($param))));
        $customTag->appendChild($dom->importNode($productParamsTag));
        return $customTag;
    }

    public function towightXML($weight,$dom)
    {
        $itemWeight = $dom->createElement("Weight");
        $itemWeight->appendChild($dom->createElement("Amount",$weight));
        $itemWeight->appendChild($dom->createElement("Unit","KG"));
        return $itemWeight;
    }

    public function toitemdimensionXML($dom,$item,$easy_aws)
    {       
            $itemDimension ='';
            $itemDimension = $dom->createElement("ItemDimension");
            $itemDimension->appendChild($dom->createElement("Unit","cm"));
            $itemDimension->appendChild($dom->createElement("Length",$easy_aws['easy_aws_length']));
            $itemDimension->appendChild($dom->createElement("Width",$easy_aws['easy_aws_width']));
            $itemDimension->appendChild($dom->createElement("Height",$easy_aws['easy_aws_height']));

            return $itemDimension;
    }

    public function topriceXML($price,$dom)
    {
        $itemPrice = $dom->createElement("Price");
        $itemPrice->appendChild($dom->createElement("Amount",$price));
        $itemPrice->appendChild($dom->createElement("CurrencyCode","INR"));
        return $itemPrice;
    }
    public function toordercalculationXML($dom)
    {
        $ordercal = $dom->createElement("OrderCalculationCallbacks");
        $ordercal->appendChild($dom->createElement("CalculateTaxRates",true));
        $ordercal->appendChild($dom->createElement("CalculatePromotions",true));
        $ordercal->appendChild($dom->createElement("CalculateShippingRates",true));
        $ordercal->appendChild($dom->createElement("OrderCallbackEndpoint",$this->getBaseUrl()."checkout/cart"));
        $ordercal->appendChild($dom->createElement("ProcessOrderOnCallbackFailure",true));
        return $ordercal;
    }
    public function topromotionXML($properties,$discount,$coupancode,$dom)
    {
        $promotionXML = $dom->createElement("Promotion");
        
        $promotionXML->appendChild($dom->createElement("PromotionId",$coupancode));
        
        $benefitTag = $dom->createElement("Benefit");
        $benefitTag->appendChild($dom->importNode($this->fixedpricediscount($discount,$dom),true));
        $promotionXML->appendChild($benefitTag);
        
        return $promotionXML;
    }
    public function fixedpricediscount($price,$dom)
    {
        $fixedpricediscount1 = $dom->createElement("FixedAmountDiscount");
        $fixedpricediscount1->appendChild($dom->createElement("Amount",$price));
        $fixedpricediscount1->appendChild($dom->createElement("CurrencyCode","INR"));
        return $fixedpricediscount1;
    } 
    public function calculateDiscountDiff()
    {
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $cart_items = $cart->getItemsCollection();
        $total_incl_tax = $diff = 0;
        $total_excl_tax = 0;
        $getCartItems = $this->getShippableItems();
        
        foreach ($getCartItems as $key => $value) {
            $total_incl_tax += $value->getRowTotalInclTax();
            $total_excl_tax += $value->getRowTotal();
        }
        $totals = $cart->getTotals();
        if(isset($totals['tax']) && $totals['tax']->getValue()) {
                $tax = abs($totals["tax"]->getValue());
        }
        if($total_incl_tax-$total_excl_tax-$tax > 0)
            $diff = $total_incl_tax-$total_excl_tax-$tax;
        return $diff;
    }

    public function easyhsip_weight_check()
    {
        $getCartItems = $this->getShippableItems();
        $total_weight = 0;
        foreach($getCartItems as $item)
        {
              $product_id=$item->getProductId();
              $product=Mage::getModel('catalog/product')->load($product_id)->getData();

	$easyship_weight_unit = Mage::getStoreConfig('paywithamazon/general/easyship_weight');
	$weight = $item->getWeight();

	if($easyship_weight_unit=="gram") 
		$weight= $weight/1000; 
	
	
            if($weight > 0)
            {
                $total_weight += ($weight)*($item->getQty());
            }
            else
            {
            $easy_aws_length = isset($product['easy_aws_length']) ? $product['easy_aws_length'] : 0 ;
            $easy_aws_width = isset($product['easy_aws_width']) ? $product['easy_aws_width'] : 0 ;
            $easy_aws_height = isset($product['easy_aws_height']) ? $product['easy_aws_height'] : 0 ;
                if($easy_aws_length > 0 && $easy_aws_width > 0 && $easy_aws_height > 0){
                    $vol_weight = (float)($easy_aws_length*$easy_aws_width*$easy_aws_height)/5000;
                    $total_weight += $vol_weight*($item->getQty());   
                }
            }
        }

        return $total_weight;
    }
}

