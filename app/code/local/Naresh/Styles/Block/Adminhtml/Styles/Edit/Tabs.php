<?php

class Naresh_Styles_Block_Adminhtml_Styles_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('styles_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('styles')->__('Front Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('styles')->__('Front Style Information'),
          'title'     => Mage::helper('styles')->__('Front Style Information'),
          'content'   => $this->getLayout()->createBlock('styles/adminhtml_styles_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}