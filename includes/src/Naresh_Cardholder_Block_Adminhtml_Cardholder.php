<?php
class Naresh_Cardholder_Block_Adminhtml_Cardholder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_cardholder';
    $this->_blockGroup = 'cardholder';
    $this->_headerText = Mage::helper('cardholder')->__('Cardholder Names Manager');
    $this->_addButtonLabel = Mage::helper('cardholder')->__('Add New Cardholder Name');
    parent::__construct();
  }
}