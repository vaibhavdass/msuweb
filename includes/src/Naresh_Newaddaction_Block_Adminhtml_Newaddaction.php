<?php
class Naresh_Newaddaction_Block_Adminhtml_Newaddaction extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_newaddaction';
    $this->_blockGroup = 'newaddaction';
    $this->_headerText = Mage::helper('newaddaction')->__('Newaddaction Attribute Manager');
    $this->_addButtonLabel = Mage::helper('newaddaction')->__('Add New Newaddaction');
    parent::__construct();
  }
}