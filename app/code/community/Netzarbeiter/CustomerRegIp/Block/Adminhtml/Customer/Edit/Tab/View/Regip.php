<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * package    Netzarbeiter_CustomerRegIp
 * copyright  Copyright (c) 2014 Vinai Kopp http://netzarbeiter.com/
 * license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Netzarbeiter_CustomerRegIp_Block_Adminhtml_Customer_Edit_Tab_View_Regip
    extends Mage_Adminhtml_Block_Template
{
    /**
     * Return the current customer model
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        return Mage::registry('current_customer');
    }

    /**
     * Return true if the customer was created in the admin store view
     *
     * @return bool
     */
    public function isCustomerCreatedInAdmin()
    {
        return $this->getCustomer()->getStoreId() == 0;
    }

    public function getCustomerRegIp()
    {
        $remoteAddr = $this->getCustomer()->getRegistrationRemoteIp();
        // DEBUG:
        // $remoteAddr = dns_get_record('google.com', DNS_A); $remoteAddr = $remoteAddr[0]['ip'];
        return $remoteAddr;
    }

    /**
     * Return the customer registration ip
     *
     * @return string
     */
    public function getCustomerRegIpHtml()
    {
        $remoteAddr = $this->getCustomerRegIp();
        if (!$this->isValidIp()) {
            $html = $this->__('- REGISTRATION IP UNAVAILABLE -');
        } else {
            $html = sprintf('%s', $remoteAddr);
        }
        return $html;
    }

    /**
     *
     * @return bool
     */
    public function isValidIp()
    {
        $remoteAddr = $this->getCustomerRegIp();
        return !empty($remoteAddr);
    }

    /**
     *
     * @return string
     */
    public function getAjaxLookupUrl()
    {
        return Mage::helper('adminhtml')->getUrl(
            'adminhtml/customerregip/lookup', array('ip' => $this->getCustomerRegIp())
        );
    }

    /**
     * Hide block if the customer hasn't been saved yet
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getCustomer() || !$this->getCustomer()->getId()) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     *
     * @return bool
     */
    public function isIpInfoDbEnabled()
    {
        return (bool)trim(Mage::getStoreConfig('customerregip/general/ipinfodb_api_key'));
    }
}
