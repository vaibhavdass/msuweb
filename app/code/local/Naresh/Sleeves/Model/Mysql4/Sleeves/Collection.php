<?php

class Naresh_Sleeves_Model_Mysql4_Sleeves_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sleeves/sleeves');
    }
}