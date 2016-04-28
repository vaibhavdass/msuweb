<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Onestepcheckout
 * @version     0.1.9
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 * */ 
class Apptha_Onestepcheckout_IndexController extends Mage_Core_Controller_Front_Action {

 
	/* function:load the onepage template and check the quotes if not available redirect to cart page   */

	
    public function indexAction() { 
        $quote = $this->getOnepage()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart');
            return;
        }
        if (!$quote->validateMinimumAmount()) {

            $error = Mage::getStoreConfig('sales/minimum_order/error_message');
            Mage::getSingleton('checkout/session')->addError($error);
            $this->_redirect('checkout/cart');
            return;
        }
        Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
        Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_secure' => true)));
        /* save billing and shipping information onload */    
        $helper = Mage::helper('onestepcheckout/checkout');
    	$this->shippingreloadAction();
        $billing_data = $this->getRequest()->getPost('billing', array());       
	    $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
        if($this->getOnepage()->getQuote()->isVirtual()) 
         {
	        $Billingdata = $helper->load_add_data($billing_data);
	        $billing_result = $this->getOnepage()->saveBilling($Billingdata, $customerAddressId);
         }
        else
        {
        	if(!empty($billing_data['use_for_shipping']))
        	{
	        	$Shippingdata = $helper->load_add_data($billing_data);	        	
				$shipping_result1 = $this->getOnepage()->saveBilling($Shippingdata, $customerAddressId);
		        $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $customerAddressId);
        	}
        	else
        	{
		        $shippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
		        $shipping_data = $this->getRequest()->getPost('shipping', array());
		     	$Shippingdata = $helper->load_add_data($shipping_data);		     	
				$shipping_result1 = $this->getOnepage()->saveBilling($Shippingdata, $customerAddressId);
		        $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $shippingAddressId);  
        	}
        }
        $this->_checkCountry();
        $this->getOnepage()->initCheckout();
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();           
         /* End of save billing and shipping information onload */
    }
    
	private function _checkCountry()
    {
    	
        //$onepage = $this->getOnepage();
        $quote = $this->getOnepage()->getQuote();
        $shipping = $quote->getShippingAddress();
        $billing = $quote->getBillingAddress();
        $default_country = false;
        $country_id = $shipping->getCountryId();
        $helper = Mage::helper('onestepcheckout/checkout');
      	$enableGeoIp = Mage::getStoreConfig('onestepcheckout/general/enable_geoip');
    		if($enableGeoIp == 1)
    		{
                        if(!$helper->getGeoIp()->countryCode){
                            $countryId = Mage::getStoreConfig('onestepcheckout/general/default_country_id');
                        }else{
                        $countryId = $helper->getGeoIp()->countryCode;
                        }
        		
    		}
    		else
    		{
    			$countryId = Mage::getStoreConfig('onestepcheckout/general/default_country_id');
    		}
    	
        if (is_null($countryId)) {
            $countryId = Mage::helper('core')->getDefaultCountry();
        }
   		 $shipping->setCountryId($countryId)->setCollectShippingRates(true)->save();
         $billing->setCountryId($countryId)->save();
         $shipping->setSameAsBilling(true)->save();
    }
    
	public function shippingreloadAction()
    {
        if ($this->_expireAjax())
        {
            return;
        }
        $shipping_method = $this->getRequest()->getPost('shipping_method');
        if(!$shipping_method)
        {
        	$shipping_method = Mage::getStoreConfig('onestepcheckout/general/default_shipping_method');
        }
        $save_shippingmethod = $this->getOnepage()->saveShippingMethod($shipping_method);          
	    if(!$save_shippingmethod)
	     {
	       $event =    Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
	                        array('request'=>$this->getRequest(),
	                            'quote'=>$this->getOnepage()->getQuote()));
	       $this->getOnepage()->getQuote()->collectTotals();
	     }
  	    $this->getOnepage()->getQuote()->collectTotals()->save(); 
        $this->getOnepage()->getQuote()->getShippingAddress()->setShippingMethod($shipping_method);
     
    }

    /* End of index Action */

    /* function:if ajax  expires  check the quouetes if not avaiable  redirect to ajaxredirectresponse  fn */

    protected function _expireAjax() {
        $activateInCart = Mage::getStoreConfig('onestepcheckout/general/Activate_apptha_onestepcheckout_cart');
     	if($activateInCart != 1):
    	if (!$this->getOnepage()->getQuote()->hasItems()
                || $this->getOnepage()->getQuote()->getHasError()
                || $this->getOnepage()->getQuote()->getIsMultiShipping()) {
            $this->_ajaxRedirectResponse();
            return true;
        }
        $action = $this->getRequest()->getActionName();
        if (Mage::getSingleton('checkout/session')->getCartWasUpdated(true)
                && !in_array($action, array('index', 'progress'))) {
            $this->_ajaxRedirectResponse();
            return true;
        }
       // return false;
        endif;
    }

    /* End of expireAjax fn */

    /* function:set session expires and send the response to Onestepcheckout.js  */

    public function _ajaxRedirectResponse() {
        $this->getResponse()
                ->setHeader('HTTP/1.1', '403 Session Expired')
                ->setHeader('Login-Required', 'true')
                ->sendResponse();
        return $this;
    }

    /* End of ajaxRedirectResponse fn */

    /* function:includes the core checkout onepage model  */

    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    /* End of getOnepage fn */

    /* function:get the username and password from ajax and check the user table  and send the result as json response to js */

    public function loginAction() {
        $username = $this->getRequest()->getPost('onestepcheckout_username', false);
        $password = $this->getRequest()->getPost('onestepcheckout_password', false);
        $session = Mage::getSingleton('customer/session');

        $result = array(
            'success' => false
        );

        if ($username && $password) {
            try {
                $session->login($username, $password);
            } catch (Exception $e) {
                $result['error'] = $e->getMessage();
            }

            if (!isset($result['error'])) {
                $result['success'] = true;
            }
        } else {
            $result['error'] = $this->__('Please enter your Email Id and password.');
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

    /* End of Login Action  */
    public function forgotPasswordAction()
    {
        $email = $this->getRequest()->getPost('email', false);

        if (!Zend_Validate::is($email, 'EmailAddress'))
        {
            $result = array('success'=>false);
        }
        else
        {

            $customer = Mage::getModel('customer/customer')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
            ->loadByEmail($email);

            if ($customer->getId())
             {
                try
                {
                    $newPassword = $customer->generatePassword();
                    $customer->changePassword($newPassword, false);
                    $customer->sendPasswordReminderEmail();
                    $result = array('success'=>true);
                }
                catch (Exception $e)
                {
                    $result = array('success'=>false, 'error'=>$e->getMessage());
                }
            }
            else
            {
                $result = array('success'=>false, 'error'=>'notfound');
            }
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

    /* function:load the product information when payment method selects */

    public function playAction()
     {
     	if ($this->_expireAjax())
        {
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /* End of Play Action  */

    /* function:load the product information when shipping method selects */

    public function reloadAction()
    {
        if ($this->_expireAjax())
        {
            return;
        }
        $shipping_method = $this->getRequest()->getPost('shipping_method');
        if(!$shipping_method)
        {
        	$shipping_method = Mage::getStoreConfig('onestepcheckout/general/default_shipping_method');
        }
        $save_shippingmethod = $this->getOnepage()->saveShippingMethod($shipping_method);          
	    if(!$save_shippingmethod)
	     {
	       $event =    Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
	                        array('request'=>$this->getRequest(),
	                            'quote'=>$this->getOnepage()->getQuote()));
	       $this->getOnepage()->getQuote()->collectTotals();
	     }
  	    $this->getOnepage()->getQuote()->collectTotals()->save(); 
        $this->getOnepage()->getQuote()->getShippingAddress()->setShippingMethod($shipping_method);
        $this->loadLayout();
        $this->renderLayout();
    }

    /* End of reload Action  */
    
	 /* Start of paymentreload Action  */
    /* payment reload when changes the shipping methods */
    
 	public function paymentreloadAction()
    {       
        $this->loadLayout(false);
        $this->renderLayout();
    }
    
     /* End of paymentreload Action  */
    
    public function summaryAction()
    {
        if ($this->_expireAjax())
        {

            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }
    //ajax save billing function
    //save billing,shipping,payment information
     public function savebillingAction()
    {
        $billing_data = $this->getRequest()->getPost('billing', array());
        $shipping_data = $this->getRequest()->getPost('shipping', array());
       
        $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
        $shippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
        $quote = $this->getOnepage()->getQuote();
        $shipping = $quote->getShippingAddress();
        $billing = $quote->getBillingAddress();
        if(isset($billing_data['use_for_shipping']) == 1) {
        $billingCountryId = $billing_data['country_id'];
        $billingRegionId = $billing_data['region_id'];
        $billingZipcode = $billing_data['postcode'];
        $billingRegion = $billing_data['region'];
        $billingCity = $billing_data['city'];
        $this->getOnepage()->getQuote()->getBillingAddress()
                                       ->setCountryId($billingCountryId)
                                       ->setRegionId($billingRegionId)
                                       ->setPostcode($billingZipcode)
                                       ->setRegion($billingRegion)
                                       ->setCity($billingCity)
                                       ->setCollectShippingRates(true);
        $this->getOnepage()->getQuote()->getShippingAddress()->collectTotals();
        $this->getOnepage()->getQuote()->save();
        }
        else{
        $shippingCountryId = $shipping_data['country_id'];
        $shippingRegionId = $shipping_data['region_id'];
        $shippingZipcode = $shipping_data['postcode'];
        $shippingRegion = $shipping_data['region'];
        $shippingCity = $shipping_data['city'];
        $this->getOnepage()->getQuote()->getShippingAddress()
                                       ->setCountryId($shippingCountryId)
                                       ->setRegionId($shippingRegionId)
                                       ->setPostcode($shippingZipcode)
                                       ->setRegion($shippingRegion)
                                       ->setCity($shippingCity)
                                       ->setCollectShippingRates(true);
        $this->getOnepage()->getQuote()->getShippingAddress()->collectTotals();
        $this->getOnepage()->getQuote()->save();
        }
       
       if(Mage::helper('customer')->isLoggedIn()){
            if(!empty($customerAddressId)){
                $billingAddress = Mage::getModel('customer/address')->load($customerAddressId);
                if(is_object($billingAddress) && $billingAddress->getCustomerId() ==  Mage::helper('customer')->getCustomer()->getId()){
                    $billing_data = array_merge($billing_data, $billingAddress->getData());
                }
            }
//            if(!empty($shippingAddressId)){
//                $shippingAddress = Mage::getModel('customer/address')->load($shippingAddressId);
//                if(is_object($shippingAddress) && $shippingAddress->getCustomerId() ==  Mage::helper('customer')->getCustomer()->getId()){
//                    $shipping_data = array_merge($shipping_data, $shippingAddress->getData());
//                }
//            }
       }
           
        /* start of save billing and shipping information for tax calculation */
           
    	$config = Mage::getStoreConfig('tax/calculation/based_on');
        $helper = Mage::helper('onestepcheckout/checkout');
        if($config=="billing")
        {
              $billing_info = $helper->load_add_data($billing_data);
              $billing_result = $this->getOnepage()->saveBilling($billing_info, $customerAddressId);
        }
        else
        {
            if(!empty($billing_data['use_for_shipping']))
             {
               $Billingdata = $helper->load_add_data($billing_data);
               $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
             }
        	else
             {
            	if($this->getOnepage()->getQuote()->isVirtual()) 
            	 {
            	 	$billing_info = $helper->load_add_data($billing_data);
              		$billing_result = $this->getOnepage()->saveBilling($billing_info, $customerAddressId);
            	 }
            	else
            	{
                	$shipping_info = $helper->load_add_data($shipping_data);
                	$shipping_result = $this->getOnepage()->saveShipping($shipping_info, $shippingAddressId);
            	}
             }
        }
       
           
           /* End  of save billing and shipping information for tax calculation */
         
           
           //if shipping same as billing
         // save billing country,region,city,postcode to shipping
        if(!empty($billing_data['use_for_shipping'])) 
        {
            if(!empty($billing_data['country_id'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCountryId($billing_data['country_id'])->setCollectShippingRates(true);
            }
             if(!empty($billing_data['region_id'])){
                 $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($billing_data['region_id'])->setCollectShippingRates(true);
            }
            if(!empty($billing_data['region'])){

                $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($billing_data['region'])->setCollectShippingRates(true);
            }
            if(!empty($billing_data['city'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCity($billing_data['city'])->setCollectShippingRates(true);
            }
            if(!empty($billing_data['postcode'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setPostcode($billing_data['postcode'])->setCollectShippingRates(true);
            }
        }
        else
        {
            if(!empty($shipping_data['country_id'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCountryId($shipping_data['country_id'])->setCollectShippingRates(true);
            }
            else {$this->getOnepage()->getQuote()->getBillingAddress()->setCountryId($shipping_data['country_id'])->setCollectShippingRates(true);}
             if(!empty($shipping_data['region_id'])){
                 $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($shipping_data['region_id'])->setCollectShippingRates(true);
            }
            if(!empty($shipping_data['region'])){

                $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($shipping_data['region'])->setCollectShippingRates(true);
            }
            if(!empty($shipping_data['city'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCity($shipping_data['city'])->setCollectShippingRates(true);
            }
            if(!empty($shipping_data['postcode'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setPostcode($shipping_data['postcode'])->setCollectShippingRates(true);
            }
        }
    $paymentMethod = $this->getRequest()->getPost('payment_method', false);
    if($this->getOnepage()->getQuote()->isVirtual()) 
      {
          $this->getOnepage()->getQuote()->getBillingAddress()->setPaymentMethod(!empty($paymentMethod) ? $paymentMethod : null);
      }
     else
      {
            $this->getOnepage()->getQuote()->getShippingAddress()->setPaymentMethod(!empty($paymentMethod) ? $paymentMethod : null);
      }

        $this->loadLayout(false);
        $this->renderLayout();

    }
    protected function _getReviewHtml()
    {
        return $this->getLayout()
        ->createBlock('paypal/iframe')
        ->toHtml();
    }

    /* function:get all the information from onepage form and save the order using ajax */

    public function saveOrderAction() {
        if ($this->_expireAjax()) {

            return;
        }
            $helper = Mage::helper('onestepcheckout/checkout');
            if ($this->getRequest()->isPost()) {
            $Method = $this->getRequest()->getPost('checkout_method', false);
            $Billingdata = $this->getRequest()->getPost('billing', array());            
            $Billingdata = $helper->load_exclude_data($Billingdata);
            $Paymentdata = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->saveCheckoutMethod($Method);
            if(isset($Billingdata['is_subscribed']) && !empty($Billingdata['is_subscribed']))
            {
                    $customer = $this->getOnepage()->getCheckout()->setCustomerIsSubscribed(1);
            }
                $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
                if (isset($Billingdata['email'])) {
                    $Billingdata['email'] = trim($Billingdata['email']);
                }
//save billing
             $Billingresult = $this->getOnepage()->saveBilling($Billingdata, $customerAddressId);
             if(!empty($Billingresult))
            {
                        $result['error'] = true;
                        $result['error_messages'] = $Billingresult['message'];
                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                        return;
            }
//save payment
            $Paymentresult = $this->getOnepage()->savePayment($Paymentdata);
             if(!empty($Paymentresult))
            {
                        $result['error'] = true;
                        $result['error_messages'] = $Paymentresult['message'];
                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                        return;
            }
            if (isset($Billingdata['email'])) {
                //zend validator
                if (!Zend_Validate::is($Billingdata['email'], 'EmailAddress')) {
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Invalid Email address');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
                // check email already exists
                if ($Method == 'register') {
                    $cust_exist = Mage::helper('onestepcheckout/checkout')->IscustomerEmailExists($Billingdata['email']);
                    if ($cust_exist) {
                        $result['error'] = true;
                        $result['error_messages'] = $this->__('Email address Already Exists');
                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                        return;
                    }
                }
            }
            $Shippingdata = $this->getRequest()->getPost('shipping', array());
            $ShippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
            if (!empty($Billingdata['use_for_shipping']))
            {
                $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
            }
            else if (!empty($ShippingAddressId)) {

                    $shippingAddress = Mage::getModel('customer/address')->load($ShippingAddressId);
                if (is_object($shippingAddress) && $shippingAddress->getCustomerId() == Mage::helper('customer')->getCustomer()->getId())
                {
                        $Shippingdata = array_merge($Shippingdata, $shippingAddress->getData());
                        $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $ShippingAddressId);
                    }
            } else if (empty($Billingdata['use_for_shipping']) && !$ShippingAddressId)
            {
                $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $ShippingAddressId);
                } else {
                    $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
                }
            $ShippingMethoddata = $this->getRequest()->getPost('shipping_method', '');
            $ShippingMethodresult = $this->getOnepage()->saveShippingMethod($ShippingMethoddata);
            // }
            }
            Mage::log('arg6',null,'opc.log');
            Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method', array('request' => $this->getRequest(), 'quote' => $this->getOnepage()->getQuote()));
            $data = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->savePayment($data);
            // get section and redirect data
            $redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
            if ($redirectUrl) {
                if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                    $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                    if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                        $result['success'] = false;
                        $result['error'] = true;
                        $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                        return;
                    }
                }
                $result['success'] = true;
                $result['error'] = false;
                $result['redirect'] = $redirectUrl;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                return;
            }
            $result = array();
        try {
            if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $result['success'] = false;
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }
            if ($data = $this->getRequest()->getPost('payment', false)) {
                $this->getOnepage()->getQuote()->getPayment()->importData($data);
            }
            $this->getOnepage()->saveOrder();
            $redirectUrl = $this->getOnepage()->getCheckout()->getRedirectUrl();
            $result['success'] = true;
            $result['error'] = false;

            // ***** Start of Updating Measurement Remember Module *****

            $_order = Mage::getModel('sales/order')->load(Mage::getSingleton('checkout/session')->getLastOrderId());
            $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
            $options = array();
            foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
                if(strlen($option['label']) > 0){
                    $options[$option['value']] = $option['label'];
                }
            }

            $base_currency = Mage::app()->getStore()->getBaseCurrencyCode();
            $current_currency =  Mage::app()->getStore()->getCurrentCurrencyCode();
            $currencyRates = Mage::getModel('directory/currency')->getCurrencyRates($base_currency, $current_currency);
            foreach ($currencyRates as $key => $value) {
                $rate = $value; break;
            }
            $Total_Custom_Duties_and_Taxes1 = 0;
            $subtotal = $_order->getSubtotal();
            $basesubtotal = $_order->getBaseSubtotal();
            $moduleName = 'Naresh_Taxrate';
            $gotoddpcalculations = $_order->getFeeAmount();
            if(Mage::getConfig()->getModuleConfig($moduleName)->is('active', 'true') && $gotoddpcalculations > 0){
                $countrycode = Mage::helper('checkout/cart')->getQuote()->getShippingAddress()->getCountryId();
                $taxrate = Mage::getSingleton('taxrate/taxrate')
                                            ->getCollection()
                                            ->addFieldToFilter('status',1)
                                            ->addFieldToFilter('cat_id', array('like' => '%'.$countrycode.'%'))
                                            ->getFirstItem();
                $gst_perc = ($subtotal*$taxrate->getGstPerc())/100;
                $base_gst_perc = ($basesubtotal*$taxrate->getGstPerc())/100;
                // $handling_fee = Mage::helper('directory')->currencyConvert($taxrate->getHandlingFee(), $base_currency, $current_currency);
                $handling_fee = 0;
                $tax_default_perc = ($subtotal*$taxrate->getTaxDefaultPerc())/100;
                $base_tax_default_perc = ($basesubtotal*$taxrate->getTaxDefaultPerc())/100;
                $Total_Custom_Duties_and_Taxes1 = $gst_perc + $handling_fee + $tax_default_perc;
                $Base_Total_Custom_Duties_and_Taxes1 = $base_gst_perc + $handling_fee + $base_tax_default_perc;
            }
            $subtot = 0;
            $basesubtot = 0;
            foreach ($_order->getAllItems() as $item) {
                if($Total_Custom_Duties_and_Taxes1 > 0){
                    $row = 0;
                    $baserow = 0;
                    $Total_Custom_Duties_and_Taxes = round(($item->getRowTotal()/$subtotal)*$Total_Custom_Duties_and_Taxes1,2);
                    $ddp = round($Total_Custom_Duties_and_Taxes / $item->getData('qty_ordered'),2);
                    $Base_Total_Custom_Duties_and_Taxes = round(($item->getBaseRowTotal()/$basesubtotal)*$Base_Total_Custom_Duties_and_Taxes1,2);
                    $baseddp = round($Base_Total_Custom_Duties_and_Taxes / $item->getData('qty_ordered'),2);
                    $row = $item->getRowTotal() + ($ddp * $item->getData('qty_ordered'));
                    $baserow = $item->getBaseRowTotal() + ($baseddp * $item->getData('qty_ordered'));
                    $price11 = ($item->getRowTotal()/$item->getData('qty_ordered')) + $ddp;
                    $baseprice11 = ($item->getBaseRowTotal()/$item->getData('qty_ordered')) + $baseddp;
                    $item->setRowTotal($row);
                    $item->setBaseRowTotal($baserow);
                    $subtot += $row;
                    $basesubtot += $baserow;
                    $item->setPrice(round($price11,4));
                    $item->setBasePrice(round($baseprice11,4));
                    $item->save();
                }
                $stored_stitchings = Mage::getModel('newaddaction/newaddaction')->getCollection()->addFieldToFilter('product_id',$item->getProductId())->addFieldToFilter('quote_id',$_order->getQuoteId())->getFirstItem();
                if(sizeof($stored_stitchings) > 0) {
                    foreach ($options as $key => $value) {
                        if (isset($stored_stitchings[$key]) && $stored_stitchings[$key] > 0) {
                            $is_submited = Mage::getModel('measurementremember/measurementremember')->getCollection()->addFieldToFilter('product_id',$item->getProductId())->addFieldToFilter('quote_id',$_order->getQuoteId())->addFieldToFilter('stitching_service_id',$key)->getFirstItem();
                            if ($is_submited->getMeasurementrememberId() > 0) {
                                $model = Mage::getModel('measurementremember/measurementremember')->load($is_submited->getMeasurementrememberId());
                                $model->setOrderId(Mage::getSingleton('checkout/session')->getLastOrderId());
                                $model->setIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());
                                $model->save();
                            }
                        }
                    }
                }
            }

            if($Total_Custom_Duties_and_Taxes1 > 0){
                $_order->setSubtotal($subtot);
                //$basesubtotal = $Total_Custom_Duties_and_Taxes1/$rate;
                $_order->setBaseSubtotal($basesubtot);
                $_order->setShippingAmount( $_order->getShippingAmount() + $_order->getFeeAmount() );
                $_order->setBaseShippingAmount( $_order->getBaseShippingAmount() + $_order->getBaseFeeAmount() );
                $_order->setShippingInclTax( $_order->getShippingInclTax() + $_order->getFeeAmount() );
                $_order->setBaseShippingInclTax( $_order->getBaseShippingInclTax() + $_order->getBaseFeeAmount() );
                $basegt = $_order->getGrandTotal()/$rate;
                // $_order->setBaseGrandTotal($basegt);
                $_order->save();
                $mail_content = Mage::getSingleton('checkout/session')->getLastRealOrderId();
                mail('it_magento@mysoresareeudyog.com', 'New MSU Import Duties and Taxes', $mail_content);
            }

            // ***** End of Updating Measurement Remember Module *****

        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if (!empty($message)) {
                $result['error_messages'] = $message;
            }

        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();


        } catch (Exception $e) {
            Mage::logException($e);
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $this->__('There was an error processing your order. Please contact us or try again later.');
        }
        
        $this->getOnepage()->getQuote()->save();
        /**
         * when there is redirect to third party, we don't want to save order yet.
         * we will save the order in return action.
         */
        if (isset($redirectUrl)) {
            $result['redirect'] = $redirectUrl;
        }
        /* Host pro Started*/
        if($Paymentdata['method'] == 'hosted_pro' || $Paymentdata['method'] == 'payflow_advanced'){
                $this->loadLayout('onestepcheckout_index_review');     
                $result['update_section'] = array(
                    'name' => 'paypaliframe',
                    'html' => $this->_getReviewHtml()
                );
        }
        /* Host pro Ends*/
        if ($result['success']) {
            $result['success'] = Mage::getBaseUrl() . 'checkout/onepage/success/';
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /* End of saveorder Action */

 /* start of couponcode Action */
    function couponcodeAction()
    {

        $quote = $this->getOnepage()->getQuote();
        $couponCode = (string)$this->getRequest()->getParam('code');

        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
        }

        $response = array(
            'success' => false,
            'error'=> false,
            'message' => false,
        );
        try {
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setCouponCode(strlen($couponCode) ? $couponCode : '')
            ->collectTotals()
            ->save();

            if ($couponCode) {
                if ($couponCode == $quote->getCouponCode()) {
                    $response['success'] = true;
                    $response['message'] = $this->__('Coupon code "%s" was applied successfully.',
                    Mage::helper('core')->htmlEscape($couponCode));
                }
                else {
                    $response['success'] = false;
                    $response['error'] = true;
                    $response['message'] = $this->__('Coupon code "%s" is not valid.',
                    Mage::helper('core')->htmlEscape($couponCode));
                }
            } else {
                $response['success'] = true;
                $response['message'] = $this->__('Coupon code was canceled successfully.');
            }


        }
        catch (Mage_Core_Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
        catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $this->__('Can not apply coupon code.');
        }

       
        $html = $this->getLayout()
        ->createBlock('onestepcheckout/onestep_review_info')
        ->setTemplate('onestepcheckout/onestep/review/info.phtml')
        ->toHtml();

        $response['summary'] = $html;


        $this->getResponse()->setBody(Zend_Json::encode($response));
    }
     /* End of couponcode Action */
    
   public function replayAction()
    {
        if ($this->_expireAjax())
        {

            return;
        }
        $Paymentdata = $this->getRequest()->getPost('payment');

		$quote = $this->getOnepage()->getQuote();
		if($quote->getShippingAddress()) {
			$quote->getShippingAddress()->setCollectShippingRates(true);
			$quote->collectTotals()->save();
		}

        $this->loadLayout();
        $this->renderLayout();
    }
    
}