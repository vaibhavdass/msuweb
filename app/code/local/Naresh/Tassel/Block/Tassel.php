<?php
class Naresh_Tassel_Block_Tassel extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTassel()     
     { 
        if (!$this->hasData('tassel')) {
            $this->setData('tassel', Mage::registry('tassel'));
        }
        return $this->getData('tassel');
        
    }
}