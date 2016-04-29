<?php
class Naresh_Cardholder_Block_Cardholder extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCardholder()     
     { 
        if (!$this->hasData('cardholder')) {
            $this->setData('cardholder', Mage::registry('cardholder'));
        }
        return $this->getData('cardholder');
        
    }
}