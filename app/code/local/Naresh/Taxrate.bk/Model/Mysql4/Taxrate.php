<?php

class Naresh_Taxrate_Model_Mysql4_Taxrate extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the taxrate_id refers to the key field in your database table.
        $this->_init('taxrate/taxrate', 'taxrate_id');
    }
}