<?php

class Naresh_Newaddaction_Model_Mysql4_Newaddaction_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('newaddaction/newaddaction');
    }
}