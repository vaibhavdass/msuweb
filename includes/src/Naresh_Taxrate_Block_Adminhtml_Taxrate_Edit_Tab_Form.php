<?php

class Naresh_Taxrate_Block_Adminhtml_Taxrate_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('taxrate_form', array('legend'=>Mage::helper('taxrate')->__('Taxrate Flat Rates')));

      //$fieldset1 = $form->addFieldset('taxrate_form1', array('legend'=>Mage::helper('taxrate')->__('Taxrate Flat Rates')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('taxrate')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('gst_perc', 'text', array(
          'label'     => Mage::helper('taxrate')->__('GST Percentage'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'gst_perc',
      ));
      $fieldset->addField('handling_fee', 'text', array(
          'label'     => Mage::helper('taxrate')->__('Fixed Handling Fee'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'handling_fee',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('taxrate')->__('Status'),
          'class'     => 'required-entry',
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('taxrate')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('taxrate')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('tax_default_perc', 'text', array(
          'label'     => Mage::helper('taxrate')->__('Import Duties Tax Percentage'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'tax_default_perc',
      ));
      $officehours_field = $fieldset->addField('cost_range', 'text', array(
            'name'      => 'cost_range',
            'label'     => Mage::helper('taxrate')->__('Grand Total Price Range'),
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $cost_range = $form->getElement('cost_range');
        $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('taxrate/adminhtml_taxrate_edit_renderer_pricerange'));

        $cost_range->setRenderer($this->getLayout()->createBlock('taxrate/adminhtml_taxrate_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getTaxrateData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTaxrateData());
          Mage::getSingleton('adminhtml/session')->getTaxrateData(null);
      } elseif ( Mage::registry('taxrate_data') ) {
          $form->setValues(Mage::registry('taxrate_data')->getData());
      }
      return parent::_prepareForm();
  }
}