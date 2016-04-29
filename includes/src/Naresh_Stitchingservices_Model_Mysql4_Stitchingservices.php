<?php

class Naresh_Stitchingservices_Model_Mysql4_Stitchingservices extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the stitchingservices_id refers to the key field in your database table.
        $this->_init('stitchingservices/stitchingservices', 'stitchingservices_id');
    }
}