<?php
class Naresh_Measurementremember_Block_Measurementremember extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMeasurementremember()     
     { 
        if (!$this->hasData('measurementremember')) {
            $this->setData('measurementremember', Mage::registry('measurementremember'));
        }
        return $this->getData('measurementremember');
        
    }
}