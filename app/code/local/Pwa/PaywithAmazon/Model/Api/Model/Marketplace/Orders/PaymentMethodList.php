<?php

/**
 * Amazon Marketplace Orders API: PaymentMethodList data type model
 *
 * Fields:
 * <ul>
 * <li>Method: Array<PaymentMethodEnum></li>
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
class Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Orders_PaymentMethodList extends Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Orders_Abstract {

    public function __construct($data = null) {
        $this->_fields = array(
            'Method' => array('FieldValue' => null, 'FieldType' => array('PaymentMethodEnum'))
        );
        parent::__construct($data);
    }

}
