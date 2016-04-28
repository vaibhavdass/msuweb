<?php
class Naresh_Mycategory_Block_Mycategory extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMycategory()     
     { 
        if (!$this->hasData('mycategory')) {
            $this->setData('mycategory', Mage::registry('mycategory'));
        }
        return $this->getData('mycategory');
        
    }
}