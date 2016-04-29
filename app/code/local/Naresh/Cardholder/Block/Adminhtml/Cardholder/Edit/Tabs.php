<?php

class Naresh_Cardholder_Block_Adminhtml_Cardholder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('cardholder_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('cardholder')->__('Cardholder Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('cardholder')->__('Cardholder Information'),
          'title'     => Mage::helper('cardholder')->__('Cardholder Information'),
          'content'   => $this->getLayout()->createBlock('cardholder/adminhtml_cardholder_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}