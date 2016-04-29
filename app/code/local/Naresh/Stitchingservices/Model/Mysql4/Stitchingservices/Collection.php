<?php

class Naresh_Stitchingservices_Model_Mysql4_Stitchingservices_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stitchingservices/stitchingservices');
    }
}