<?php
class Naresh_Lehanga_Block_Lehanga extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getLehanga()     
     { 
        if (!$this->hasData('lehanga')) {
            $this->setData('lehanga', Mage::registry('lehanga'));
        }
        return $this->getData('lehanga');
        
    }
}