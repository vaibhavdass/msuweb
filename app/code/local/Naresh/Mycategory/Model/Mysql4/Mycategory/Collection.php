<?php

class Naresh_Mycategory_Model_Mysql4_Mycategory_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mycategory/mycategory');
    }
}