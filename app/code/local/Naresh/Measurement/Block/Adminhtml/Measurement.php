<?php
class Naresh_Measurement_Block_Adminhtml_Measurement extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_measurement';
    $this->_blockGroup = 'measurement';
    $this->_headerText = Mage::helper('measurement')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('measurement')->__('Add Item');
    parent::__construct();
  }
}