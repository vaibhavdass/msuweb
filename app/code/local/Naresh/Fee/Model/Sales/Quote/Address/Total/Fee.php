<?php
class Naresh_Fee_Model_Sales_Quote_Address_Total_Fee extends Mage_Sales_Model_Quote_Address_Total_Abstract{
	protected $_code = 'fee';

	public function collect(Mage_Sales_Model_Quote_Address $address)
	{
		parent::collect($address);
		$this->_setAmount(0);
		$this->_setBaseAmount(0);
		$items = $this->_getAddressItems($address);
		if (!count($items)) {
			return $this; //this makes only address type shipping to come through
		}
		$base_currency = Mage::app()->getStore()->getBaseCurrencyCode();
		$current_currency =  Mage::app()->getStore()->getCurrentCurrencyCode();
		$quote = $address->getQuote();
		$showddp = Mage::app()->getRequest()->getParam('shipping_method_1');
		if ($showddp == 'on') {
			if(Naresh_Fee_Model_Fee::canApply($address)){
				$exist_amount = $quote->getFeeAmount();
				$fee = Naresh_Fee_Model_Fee::getFee($address['country_id']);
				$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				// $query = "SELECT * FROM `taxrate` WHERE `cat_id` LIKE '%".$address['country_id']."%' AND `status` = 1 LIMIT 0, 1";
				// $data = $read->fetchAll($query);
				// $taxrate = Mage::getSingleton('taxrate/taxrate')
				// 							->getCollection()
				// 							->addFieldToFilter('status',1)
				// 							->addFieldToFilter('cat_id', array('like' => '%'.$countrycode.'%'))
				// 							->getFirstItem();
				// $handling_fee = Mage::helper('directory')->currencyConvert($taxrate->getHandlingFee(), $base_currency, $current_currency);

				$currencyRates = Mage::getModel('directory/currency')->getCurrencyRates($base_currency, $current_currency);
                foreach ($currencyRates as $key => $value) {
                    $rate = $value; break;
                }
				$basefee = round($fee/$rate,4);
				$address->setFeeAmount($fee);
				$address->setBaseFeeAmount($basefee);
				$quote->setFeeAmount($fee);
				$address->setGrandTotal($address->getGrandTotal() + $fee);
				$address->setBaseGrandTotal($address->getBaseGrandTotal() + $basefee);
				$address->setCollectShippingRates($fee);
			}
		}
	}
	public function fetch(Mage_Sales_Model_Quote_Address $address)
	{
		$amt = $address->getFeeAmount();
		if ($amt > 0) {
			$address->addTotal(array(
				'code'=>$this->getCode(),
				'title'=>Mage::helper('fee')->__('Fixed Import Handling Charges'),
				'value'=> $amt
			));
		}
		return $this;
	}
}