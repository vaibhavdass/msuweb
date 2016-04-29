<?php

class Naresh_Mycategory_Model_Mysql4_Mycategory extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the style_id refers to the key field in your database table.
        $this->_init('mycategory/mycategory', 'mycategory_id');
    }
}