<?php
class Naresh_Taxrate_Block_Adminhtml_Taxrate extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_taxrate';
    $this->_blockGroup = 'taxrate';
    $this->_headerText = Mage::helper('taxrate')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('taxrate')->__('Add Item');
    parent::__construct();
  }
}