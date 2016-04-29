<?php

class Naresh_Lehanga_Model_Mysql4_Lehanga_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('lehanga/lehanga');
    }
}