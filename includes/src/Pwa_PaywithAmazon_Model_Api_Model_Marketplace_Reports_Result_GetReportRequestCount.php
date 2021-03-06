<?php

/**
 * Amazon Marketplace Reports API: GetReportRequestCount result model
 *
 * Fields:
 * <ul>
 * <li>Count: int</li>
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
class Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Result_GetReportRequestCount extends Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Abstract {

    public function __construct($data = null) {
        $this->_fields = array(
            'Count' => array('FieldValue' => null, 'FieldType' => 'int')
        );
        parent::__construct($data);
    }

}
