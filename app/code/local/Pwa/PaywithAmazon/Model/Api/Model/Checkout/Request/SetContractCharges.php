<?php

/**
 * Amazon Checkout API: SetContractCharges request model
 *
 * Fields:
 * <ul>
 * <li>PurchaseContractId: string</li>
 * <li>Charges: Pwa_PaywithAmazon_Model_Api_Model_Checkout_Charges</li>
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
class Pwa_PaywithAmazon_Model_Api_Model_Checkout_Request_SetContractCharges extends Pwa_PaywithAmazon_Model_Api_Model_Checkout_Abstract {

    public function __construct($data = null) {
        $this->_fields = array(
            'PurchaseContractId' => array('FieldValue' => null, 'FieldType' => 'string'),
            'Charges' => array('FieldValue' => null, 'FieldType' => 'Pwa_PaywithAmazon_Model_Api_Model_Checkout_Charges')
        );
        parent::__construct($data);
    }

    public function convertToQueryString() {
        $params = array();
        $params['Action'] = 'SetContractCharges';
        if ($this->issetPurchaseContractId()) {
            $params['PurchaseContractId'] = $this->getPurchaseContractId();
        }
        if ($this->issetCharges()) {
            $charges = $this->getCharges();
            if ($charges->issetTax()) {
                $tax = $charges->getTax();
                if ($tax->issetAmount()) {
                    $params['Charges.Tax.Amount'] = $tax->getAmount();
                }
                if ($tax->issetCurrencyCode()) {
                    $params['Charges.Tax.CurrencyCode'] = $tax->getCurrencyCode();
                }
            }
            if ($charges->issetShipping()) {
                $shipping = $charges->getShipping();
                if ($shipping->issetAmount()) {
                    $params['Charges.Shipping.Amount'] = $shipping->getAmount();
                }
                if ($shipping->issetCurrencyCode()) {
                    $params['Charges.Shipping.CurrencyCode'] = $shipping->getCurrencyCode();
                }
            }
            if ($charges->issetGiftWrap()) {
                $giftWrap = $charges->getGiftWrap();
                if ($giftWrap->issetAmount()) {
                    $params['Charges.GiftWrap.Amount'] = $giftWrap->getAmount();
                }
                if ($giftWrap->issetCurrencyCode()) {
                    $params['Charges.GiftWrap.CurrencyCode'] = $giftWrap->getCurrencyCode();
                }
            }
            if ($charges->issetPromotions()) {
                $promotions = $charges->getPromotions();
                $promotionsIndex = 1;
                foreach ($promotions->getPromotion() as $promotion) {
                    if ($promotion->issetPromotionId()) {
                        $params['Charges.Promotions.Promotion.' . $promotionsIndex . '.PromotionId'] = $promotion->getPromotionId();
                    }
                    if ($promotion->issetDescription()) {
                        $params['Charges.Promotions.Promotion.' . $promotionsIndex . '.Description'] = $promotion->getDescription();
                    }
                    if ($promotion->issetDiscount()) {
                        $discount = $promotion->getDiscount();
                        if ($discount->issetAmount()) {
                            $params['Charges.Promotions.Promotion.' . $promotionsIndex . '.Discount.Amount'] = $discount->getAmount();
                        }
                        if ($discount->issetCurrencyCode()) {
                            $params['Charges.Promotions.Promotion.' . $promotionsIndex . '.Discount.CurrencyCode'] = $discount->getCurrencyCode();
                        }
                    }
                    $promotionsIndex++;
                }
            }
        }
        return $params;
    }

}
