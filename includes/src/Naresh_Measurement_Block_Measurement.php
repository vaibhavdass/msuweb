<?php
class Naresh_Measurement_Block_Measurement extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMeasurement()     
     { 
        if (!$this->hasData('measurement')) {
            $this->setData('measurement', Mage::registry('measurement'));
        }
        return $this->getData('measurement');
        
    }
}