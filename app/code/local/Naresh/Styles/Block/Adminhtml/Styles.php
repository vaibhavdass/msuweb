<?php
class Naresh_Styles_Block_Adminhtml_Styles extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_styles';
    $this->_blockGroup = 'styles';
    $this->_headerText = Mage::helper('styles')->__('Front Style Manager');
    $this->_addButtonLabel = Mage::helper('styles')->__('Add New Front Style');
    parent::__construct();
  }
}