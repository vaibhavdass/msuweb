<?php
class Naresh_Salwar_Block_Salwar extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSalwar()     
     { 
        if (!$this->hasData('salwar')) {
            $this->setData('salwar', Mage::registry('salwar'));
        }
        return $this->getData('salwar');
        
    }
}