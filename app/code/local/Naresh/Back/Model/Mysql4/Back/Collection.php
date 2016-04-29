<?php

class Naresh_Back_Model_Mysql4_Back_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('back/back');
    }
}