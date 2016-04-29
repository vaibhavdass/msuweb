<?php

class Naresh_Newaddaction_Model_Mysql4_Newaddaction extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the service_id refers to the key field in your database table.
        $this->_init('newaddaction/newaddaction', 'service_id');
    }
}