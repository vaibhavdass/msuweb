<?php
class Naresh_Sleeves_Block_Sleeves extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSleeves()     
     { 
        if (!$this->hasData('sleeves')) {
            $this->setData('sleeves', Mage::registry('sleeves'));
        }
        return $this->getData('sleeves');
        
    }
}