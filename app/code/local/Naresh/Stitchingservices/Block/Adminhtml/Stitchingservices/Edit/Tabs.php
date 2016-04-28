<?php

class Naresh_Stitchingservices_Block_Adminhtml_Stitchingservices_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('stitchingservices_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('stitchingservices')->__('Stitchingservices'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('stitchingservices')->__('Stitchingservices Information'),
          'title'     => Mage::helper('stitchingservices')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('stitchingservices/adminhtml_stitchingservices_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}