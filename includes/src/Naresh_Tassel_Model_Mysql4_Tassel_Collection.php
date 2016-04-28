<?php

class Naresh_Tassel_Model_Mysql4_Tassel_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tassel/tassel');
    }
}