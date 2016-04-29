<?php
class Naresh_Measurementremember_Block_Adminhtml_Measurementremember extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_measurementremember';
    $this->_blockGroup = 'measurementremember';
    $this->_headerText = Mage::helper('measurementremember')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('measurementremember')->__('Add Item');
    parent::__construct();
  }
}