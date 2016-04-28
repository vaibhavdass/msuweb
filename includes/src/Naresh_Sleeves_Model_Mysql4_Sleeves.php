<?php

class Naresh_Sleeves_Model_Mysql4_Sleeves extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the sleeves_id refers to the key field in your database table.
        $this->_init('sleeves/sleeves', 'sleeves_id');
    }
}