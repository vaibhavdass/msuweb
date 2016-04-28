<?php
class Naresh_Newaddaction_Block_Newaddaction extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getNewaddaction()     
     { 
        if (!$this->hasData('newaddaction')) {
            $this->setData('newaddaction', Mage::registry('newaddaction'));
        }
        return $this->getData('newaddaction');
        
    }
}