<?php
class Naresh_Lehanga_Block_Adminhtml_Lehanga extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_lehanga';
    $this->_blockGroup = 'lehanga';
    $this->_headerText = Mage::helper('lehanga')->__('Lehanga Style Manager');
    $this->_addButtonLabel = Mage::helper('lehanga')->__('Add New Lehanga Style');
    parent::__construct();
  }
}