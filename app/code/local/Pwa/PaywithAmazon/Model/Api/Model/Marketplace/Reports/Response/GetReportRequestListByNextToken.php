<?php

/**
 * Amazon Marketplace Reports API: GetReportRequestListByNextToken response model
 *
 * Fields:
 * <ul>
 * <li>GetReportRequestListByNextTokenResult: Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Result_GetReportRequestListByNextToken</li>
 * <li>ResponseMetadata: Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_ResponseMetadata</li>
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
class Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Response_GetReportRequestListByNextToken extends Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Abstract {

    public function __construct($data = null) {
        $this->_fields = array(
            'GetReportRequestListByNextTokenResult' => array('FieldValue' => null, 'FieldType' => 'Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Result_GetReportRequestListByNextToken'),
            'ResponseMetadata' => array('FieldValue' => null, 'FieldType' => 'Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_ResponseMetadata')
        );
        parent::__construct($data);
    }

    /**
     * Construct Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Response_GetReportRequestListByNextToken from XML string
     *
     * @param string $xml XML string to construct from
     * @return Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Response_GetReportRequestListByNextToken
     */
    public static function fromXML($xml) {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('a', self::getConfigData('api_namespace', array('api' => 'mws_reports')));
        $response = $xpath->query('//a:GetReportRequestListByNextTokenResponse');
        if ($response->length == 1) {
            return new Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Response_GetReportRequestListByNextToken($response->item(0));
        } else {
            Mage::helper('paywithamazon')->throwException(
                Mage::helper('paywithamazon')->__('Unable to construct %s from provided XML. Make sure that %s is a root element.', 'Pwa_PaywithAmazon_Model_Api_Model_Marketplace_Reports_Response_GetReportRequestListByNextToken', 'GetReportRequestListByNextTokenResponse'),
                null,
                array('area' => 'Amazon MWS Reports')
            );
        }
    }

}
