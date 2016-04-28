<?php

class Naresh_Stitchingservices_Model_Checkout_Cart extends Mage_Checkout_Model_Cart
{
    /**
     * Add product to shopping cart (quote)
     *
     * @param   int|Mage_Catalog_Model_Product $productInfo
     * @param   mixed $requestInfo
     * @return  Mage_Checkout_Model_Cart
     */
    public function addProduct($productInfo, $requestInfo=null)
    {
        Mage::log($productInfo);
        parent::addProduct($productInfo, $requestInfo);

    }
}