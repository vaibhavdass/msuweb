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
 * @category   Mage
 * @package    Mage_Secureebs
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Secureebs Configuration Model
 *
 * @category   Mage
 * @package    Mage_Secureebs
 * @name       Mage_Secureebs_Model_Config
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Mage_Secureebs_Model_Config extends Varien_Object
{
    /**
     *  Return config var
     *
     *  @param    string Var key
     *  @param    string Default value for non-existing key
     *  @return	  mixed
     */
    public function getConfigData($key, $default=false)
    {
        if (!$this->hasData($key)) {
            $value = Mage::getStoreConfig('payment/secureebs_standard/'.$key);
            if (is_null($value) || false===$value) {
                $value = $default;
            }
            $this->setData($key, $value);
        }
        return $this->getData($key);
    }

    /**
     *  Return Transaction Mode registered in Secure Ebs Admnin Panel
     *
     *  @param    none
     *  @return	  string Transaction Mode
     */
    public function getTransactionMode ()
    {
        return $this->getConfigData('mode');
    }

    /**
     *  Return Secret Key registered in Secure Ebs Admnin Panel
     *
     *  @param    none
     *  @return	  string Secret Key
     */
    public function getSecretKey ()
    {
        return $this->getConfigData('secret_key');
    }


 /**
     *  Return Account ID (general type payments) registered in Secure Ebs Admnin Panel
     *
     *  @param    none
     *  @return	  string Account ID
     */
    public function getAccountId ()
    {
        return $this->getConfigData('account_id');
    }



    /**
     *  Return Store description sent to Secureebs
     *
     *  @return	  string Description
     */
    public function getDescription ()
    {
        $description = $this->getConfigData('description');
        return $description;
    }

    /**
     *  Return new order status
     *
     *  @return	  string New order status
     */
    public function getNewOrderStatus ()
    {
        return $this->getConfigData('order_status');
    }

    /**
     *  Return debug flag
     *
     *  @return	  boolean Debug flag (0/1)
     */
    public function getDebug ()
    {
        return $this->getConfigData('debug_flag');
    }

    /**
     *  Return accepted currency
     *
     *  @param    none
     *  @return	  string Currenc
     */
    public function getCurrency ()
    {
        return $this->getConfigData('currency');
    }

    /**
     *  Return client interface language
     *
     *  @param    none
     *  @return	  string(2) Accepted language
     */
    public function getLanguage ()
    {
        return $this->getConfigData('language');
    }
}