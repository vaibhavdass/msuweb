<?php

class Naresh_Taxrate_Block_Adminhtml_Taxrate_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('taxrate_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('taxrate')->__('Taxrate Rates'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('taxrate')->__('Flat Rate Information'),
          'title'     => Mage::helper('taxrate')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('taxrate/adminhtml_taxrate_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}