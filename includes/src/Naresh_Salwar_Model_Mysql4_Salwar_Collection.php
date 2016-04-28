<?php

class Naresh_Salwar_Model_Mysql4_Salwar_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('salwar/salwar');
    }
}