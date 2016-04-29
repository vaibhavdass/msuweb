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
class Pwa_PaywithAmazon_Model_Payment extends Mage_Payment_Model_Method_Abstract {

    protected $_code = 'amazonpayments';
    protected $_infoBlockType = 'paywithamazon/payment_info';

    protected $_isGateway = false;
    protected $_canAuthorize = true;
    protected $_canCapture = false;
    protected $_canCapturePartial = false;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = false;
    protected $_canVoid = true;
    protected $_canUseInternal = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = false;
    protected $_isInitializeNeeded = true;

    /**
     * Get checkout session
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckout() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    protected function _isAmazonCheckout() {
        $_module = Mage::app()->getRequest()->getModuleName();
        if ($this->_getCheckoutMethod() == Pwa_PaywithAmazon_Model_Abstract::CHECKOUT_METHOD_AMAZON && $_module == 'paywithamazon') return true;
        return false;
    }

    protected function _getCheckoutMethod() {
        return $this->_getCheckout()->getQuote()->getData('checkout_method');
    }

    /**
     * Check whether payment method can be used
     *
     * @param Mage_Sales_Model_Quote
     * @return bool
     */
    public function isAvailable($quote = null) {
        $checkResult = new StdClass;
        $checkResult->isAvailable = Mage::helper('paywithamazon')->getConfigData('active') ?
                ($this->_isAmazonCheckout() ? true : false) :
                false;
        Mage::dispatchEvent('payment_method_is_active', array(
            'result' => $checkResult,
            'method_instance' => $this,
            'quote' => $quote,
        ));
        return $checkResult->isAvailable;
    }

    /**
     * Instantiate state and set it to state object
     * @param string $paymentAction
     * @param Varien_Object
     */
    public function initialize($paymentAction, $stateObject) {
        $state = Mage_Sales_Model_Order::STATE_NEW;
        $stateObject->setState($state);
        $stateObject->setStatus('pay_with_amazon');
        $stateObject->setIsNotified(false);
        return $this;
    }

    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('paywithamazon/checkout/success');
    }

}
