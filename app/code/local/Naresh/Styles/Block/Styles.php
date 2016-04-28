<?php
class Naresh_Styles_Block_Styles extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStyles()     
     { 
        if (!$this->hasData('styles')) {
            $this->setData('styles', Mage::registry('styles'));
        }
        return $this->getData('styles');
        
    }
}