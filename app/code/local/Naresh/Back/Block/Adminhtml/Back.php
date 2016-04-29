<?php
class Naresh_Back_Block_Adminhtml_Back extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_back';
    $this->_blockGroup = 'back';
    $this->_headerText = Mage::helper('back')->__('Back Style Manager');
    $this->_addButtonLabel = Mage::helper('back')->__('Add New Back Style');
    parent::__construct();
  }
}