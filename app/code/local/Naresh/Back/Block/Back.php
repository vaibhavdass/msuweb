<?php
class Naresh_Back_Block_Back extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getBack()     
     { 
        if (!$this->hasData('back')) {
            $this->setData('back', Mage::registry('back'));
        }
        return $this->getData('back');
        
    }
}