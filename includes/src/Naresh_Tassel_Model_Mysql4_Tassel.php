<?php

class Naresh_Tassel_Model_Mysql4_Tassel extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the style_id refers to the key field in your database table.
        $this->_init('tassel/tassel', 'tassel_id');
    }
}