<?php
class Naresh_Salwar_Block_Adminhtml_Salwar extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_salwar';
    $this->_blockGroup = 'salwar';
    $this->_headerText = Mage::helper('salwar')->__('Salwar Style Manager');
    $this->_addButtonLabel = Mage::helper('salwar')->__('Add New Salwar Style');
    parent::__construct();
  }
}