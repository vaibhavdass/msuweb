<?php

class Naresh_Salwar_Model_Mysql4_Salwar extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the style_id refers to the key field in your database table.
        $this->_init('salwar/salwar', 'salwar_id');
    }
}