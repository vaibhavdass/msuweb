<?php
class Naresh_Fee_Model_Fee extends Varien_Object{
	const FEE_AMOUNT = 10;

	public static function getFee($countrycode){
			$quote1 = Mage::getModel('checkout/session')->getQuote()->getData();
			$subtotal = $quote1['subtotal'];
			$base_currency = Mage::app()->getStore()->getBaseCurrencyCode();
			$current_currency = Mage::app()->getStore()->getCurrentCurrencyCode();
			$taxrate = Mage::getSingleton('taxrate/taxrate')
											->getCollection()
											->addFieldToFilter('status',1)
											->addFieldToFilter('cat_id', array('like' => '%'.$countrycode.'%'))
											->getFirstItem();
			$gst_perc = ($subtotal*$taxrate->getGstPerc())/100;
			$handling_fee = Mage::helper('directory')->currencyConvert($taxrate->getHandlingFee(), $base_currency, $current_currency);
			$tax_default_perc = ($subtotal*$taxrate->getTaxDefaultPerc())/100;
			$Total_Custom_Duties_and_Taxes = $gst_perc + $handling_fee + $tax_default_perc;
		return $Total_Custom_Duties_and_Taxes;
	}
	public static function canApply($address){
		//put here your business logic to check if fee should be applied or not
		//if($address->getAddressType() == 'billing'){
		return true;
		//}
	}
}