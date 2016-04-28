<?php

class Naresh_Back_Block_Adminhtml_Back_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('back_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('back')->__('Back Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('back')->__('Back Style Information'),
          'title'     => Mage::helper('back')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('back/adminhtml_back_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}