<?php

class Naresh_Measurementremember_Block_Adminhtml_Measurementremember_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('measurementremember_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('measurementremember')->__('Measurementremember Rates'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('measurementremember')->__('Flat Rate Information'),
          'title'     => Mage::helper('measurementremember')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('measurementremember/adminhtml_measurementremember_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}