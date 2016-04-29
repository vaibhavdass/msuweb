<?php
class Naresh_Mycategory_Block_Adminhtml_Mycategory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mycategory';
    $this->_blockGroup = 'mycategory';
    $this->_headerText = Mage::helper('mycategory')->__('Mycategory Style Manager');
    $this->_addButtonLabel = Mage::helper('mycategory')->__('Add New Mycategory Style');
    parent::__construct();
  }
}