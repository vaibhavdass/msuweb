<?php

class Naresh_Mycategory_Block_Adminhtml_Mycategory_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mycategory_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mycategory')->__('Mycategory Style'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mycategory')->__('Mycategory Style Information'),
          'title'     => Mage::helper('mycategory')->__('Mycategory Style Information'),
          'content'   => $this->getLayout()->createBlock('mycategory/adminhtml_mycategory_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}