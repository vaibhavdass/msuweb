<?php

class Naresh_Sleeves_Block_Adminhtml_Sleeves_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sleeves_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sleeves')->__('Sleeve Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sleeves')->__('Sleeve Style Information'),
          'title'     => Mage::helper('sleeves')->__('Sleeve Style Information'),
          'content'   => $this->getLayout()->createBlock('sleeves/adminhtml_sleeves_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}