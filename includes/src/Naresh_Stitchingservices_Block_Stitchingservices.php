<?php
class Naresh_Stitchingservices_Block_Stitchingservices extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStitchingservices()     
     { 
        if (!$this->hasData('stitchingservices')) {
            $this->setData('stitchingservices', Mage::registry('stitchingservices'));
        }
        return $this->getData('stitchingservices');
        
    }
}