<?php
class Naresh_Taxrate_Model_Flatrates extends Mage_Core_Model_Abstract
{    
    public function _construct() { 
        parent::_construct();       
        $this->_init('taxrate/flatrates');   
    }
    public function deleteVal($id){
        
    }
}