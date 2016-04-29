<?php

class Naresh_Lehanga_Block_Adminhtml_Lehanga_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('lehanga_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('lehanga')->__('Lehanga Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('lehanga')->__('Lehanga Style Information'),
          'title'     => Mage::helper('lehanga')->__('Lehanga Style Information'),
          'content'   => $this->getLayout()->createBlock('lehanga/adminhtml_lehanga_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}