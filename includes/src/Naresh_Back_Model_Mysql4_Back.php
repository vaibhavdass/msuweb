<?php

class Naresh_Back_Model_Mysql4_Back extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the back_id refers to the key field in your database table.
        $this->_init('back/back', 'back_id');
    }
}