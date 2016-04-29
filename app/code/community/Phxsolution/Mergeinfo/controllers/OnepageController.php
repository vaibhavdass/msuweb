<?php
/**
* PHXSolution Mergeinfo
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@magentocommerce.com so you can be sent a copy immediately.
*
* Original code copyright (c) 2008 Irubin Consulting Inc. DBA Varien
*
* @category   Phxsolution_Mergeinfo_OnepageController
* @package    Phxsolution_Mergeinfo
* @author     Prakash Vaniya
* @contact    contact@phxsolution.com
* @site       www.phxsolution.com
* @copyright  Copyright (c) 2014 PHXSolution Mergeinfo
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
?>

<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Phxsolution_Mergeinfo_OnepageController extends Mage_Checkout_OnepageController
{
  public function saveBillingAction()
  {
    if ($this->_expireAjax()) {
      return;
    }
    if ($this->getRequest()->isPost()) {
      
      $billingData = $this->getRequest()->getPost('billing', array());
      $name = explode(" ",$billingData['firstname']);
      if(sizeof($name) > 1) {
        $billingData['firstname'] = $name[0];
        $billingData['lastname'] = '';
        for ($i=1; $i < sizeof($name); $i++) { 
          if ($i == 1) { $billingData['lastname'] .= $name[$i]; }else{ $billingData['lastname'] .= ' '.$name[$i]; }
        }
      } else{
        $billingData['lastname'] = $billingData['firstname'];
      }
      $customerBillingAddressId = $this->getRequest()->getPost('billing_address_id', false);
      
      if (isset($billingData['email'])) {
        $billingData['email'] = trim($billingData['email']);
      }
      $result = $this->getOnepage()->saveBilling($billingData, $customerBillingAddressId);
      
      if (!isset($result['error'])) {
        if($billingData['use_for_shipping'] == 1) {
          $shippingData = $this->getRequest()->getPost('shipping', array());
          $name = explode(" ",$shippingData['firstname']);
          if(sizeof($name) > 1) {
            $shippingData['firstname'] = $name[0];
            $shippingData['lastname'] = '';
            for ($i=1; $i < sizeof($name); $i++) { 
              if ($i == 1) { $shippingData['lastname'] .= $name[$i]; }else{ $shippingData['lastname'] .= ' '.$name[$i]; }
            }
          } else{
            $shippingData['lastname'] = $shippingData['firstname'];
          }
          $customerShippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
          $result = $this->getOnepage()->saveShipping($shippingData, $customerShippingAddressId);
        }else{
          $customerBillingAddressId = $this->getRequest()->getPost('billing_address_id', false);
          $result = $this->getOnepage()->saveShipping($billingData, $customerBillingAddressId);
        }
        
        if (!isset($result['error'])) {
          if ($this->getOnepage()->getQuote()->isVirtual()) {
            $result['goto_section'] = 'payment';
            $result['update_section'] = array(
              'name' => 'payment-method',
              'html' => $this->_getPaymentMethodsHtml()
            );
          } else {
            $result['goto_section'] = 'shipping_method';
            $result['update_section'] = array(
              'name' => 'shipping-method',
              'html' => $this->_getShippingMethodsHtml()
            );
  
            $result['allow_sections'] = array('shipping_method');
            //$result['duplicateBillingInfo'] = 'false';
          }
        }
      }
      $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
  }
  public function saveShippingMethodAction() {
    if ($this->_expireAjax()) {
        return;
    }
    if ($this->getRequest()->isPost()) {
        $data = $this->getRequest()->getPost('shipping_method', '');
        $result = $this->getOnepage()->saveShippingMethod($data);
        // $result will contain error data if shipping method is empty
        if (!$result) {
            Mage::dispatchEvent(
                'checkout_controller_onepage_save_shipping_method',
                 array(
                      'request' => $this->getRequest(),
                      'quote'   => $this->getOnepage()->getQuote()));
            $this->getOnepage()->getQuote()->collectTotals();
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

            $result['goto_section'] = 'payment';
            $result['update_section'] = array(
                'name' => 'payment-method',
                'html' => $this->_getPaymentMethodsHtml()
            );
        }
        $this->getOnepage()->getQuote()->collectTotals()->save();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
  }
}