<?php

class Naresh_Styles_Model_Mysql4_Styles_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('styles/styles');
    }
}