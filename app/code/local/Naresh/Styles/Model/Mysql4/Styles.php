<?php

class Naresh_Styles_Model_Mysql4_Styles extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the style_id refers to the key field in your database table.
        $this->_init('styles/styles', 'style_id');
    }
}