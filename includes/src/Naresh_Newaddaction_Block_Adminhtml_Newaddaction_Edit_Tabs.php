<?php

class Naresh_Newaddaction_Block_Adminhtml_Newaddaction_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('newaddaction_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('newaddaction')->__('Newaddaction'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('newaddaction')->__('Newaddaction Information'),
          'title'     => Mage::helper('newaddaction')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('newaddaction/adminhtml_newaddaction_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}