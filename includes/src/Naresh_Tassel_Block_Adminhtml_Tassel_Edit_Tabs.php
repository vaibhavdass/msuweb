<?php

class Naresh_Tassel_Block_Adminhtml_Tassel_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('tassel_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('tassel')->__('Tassel Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('tassel')->__('Tassel Style Information'),
          'title'     => Mage::helper('tassel')->__('Tassel Style Information'),
          'content'   => $this->getLayout()->createBlock('tassel/adminhtml_tassel_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}