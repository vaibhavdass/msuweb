<?php
class Naresh_Taxrate_Block_Taxrate extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTaxrate()     
     { 
        if (!$this->hasData('taxrate')) {
            $this->setData('taxrate', Mage::registry('taxrate'));
        }
        return $this->getData('taxrate');
        
    }
}