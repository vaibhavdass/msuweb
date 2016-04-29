<?php
class Naresh_Sleeves_Block_Adminhtml_Sleeves extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_sleeves';
    $this->_blockGroup = 'sleeves';
    $this->_headerText = Mage::helper('sleeves')->__('Sleeve Style Manager');
    $this->_addButtonLabel = Mage::helper('sleeves')->__('Add New Sleeve Style');
    parent::__construct();
  }
}