<?php

class Naresh_Salwar_Block_Adminhtml_Salwar_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('salwar_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('salwar')->__('Salwar Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('salwar')->__('Salwar Style Information'),
          'title'     => Mage::helper('salwar')->__('Salwar Style Information'),
          'content'   => $this->getLayout()->createBlock('salwar/adminhtml_salwar_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}