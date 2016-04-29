<?php

class Naresh_Cardholder_Model_Cardholder extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('cardholder/cardholder');
    }
    public function saveMultipleFlatrates($data,$id){
        return 1;
    }
    public function deleteVal($id){
        Mage::log("Id : ".$id);
    }
}