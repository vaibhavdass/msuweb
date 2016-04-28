<?php

/**
 * Amazon Checkout API: PhysicalDestinationAttributes data type model
 *
 * Fields:
 * <ul>
 * <li>ShippingAddress: Pwa_PaywithAmazon_Model_Api_Model_Checkout_ShippingAddress</li>
 * </ul>
 *
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
class Pwa_PaywithAmazon_Model_Api_Model_Checkout_PhysicalDestinationAttributes extends Pwa_PaywithAmazon_Model_Api_Model_Checkout_Abstract {

    public function __construct($data = null) {
        $this->_fields = array(
            'ShippingAddress' => array('FieldValue' => null, 'FieldType' => 'Pwa_PaywithAmazon_Model_Api_Model_Checkout_ShippingAddress')
        );
        parent::__construct($data);
    }

}
