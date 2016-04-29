<?php

class Naresh_Measurementremember_Model_Mysql4_Measurementremember extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the measurementremember_id refers to the key field in your database table.
        $this->_init('measurementremember/measurementremember', 'measurementremember_id');
    }
}