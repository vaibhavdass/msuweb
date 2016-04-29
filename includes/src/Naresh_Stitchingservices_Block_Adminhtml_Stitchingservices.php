<?php
class Naresh_Stitchingservices_Block_Adminhtml_Stitchingservices extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stitchingservices';
    $this->_blockGroup = 'stitchingservices';
    $this->_headerText = Mage::helper('stitchingservices')->__('Stitchingservices Attribute Manager');
    $this->_addButtonLabel = Mage::helper('stitchingservices')->__('Add New Stitchingservices');
    parent::__construct();
  }
}