<?php

class Naresh_Measurement_Block_Adminhtml_Measurement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('measurement_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('measurement')->__('Measurement Rates'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('measurement')->__('Flat Rate Information'),
          'title'     => Mage::helper('measurement')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('measurement/adminhtml_measurement_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}