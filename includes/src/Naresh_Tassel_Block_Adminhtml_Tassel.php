<?php
class Naresh_Tassel_Block_Adminhtml_Tassel extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_tassel';
    $this->_blockGroup = 'tassel';
    $this->_headerText = Mage::helper('tassel')->__('Tassel Style Manager');
    $this->_addButtonLabel = Mage::helper('tassel')->__('Add New Tassel Style');
    parent::__construct();
  }
}