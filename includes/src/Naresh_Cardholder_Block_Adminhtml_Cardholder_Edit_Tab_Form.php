<?php

class Naresh_Cardholder_Block_Adminhtml_Cardholder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('cardholder_form', array('legend'=>Mage::helper('cardholder')->__('Cardholder Information')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('cardholder')->__('Cardholder Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      $fieldset->addField('invoice', 'text', array(
          'label'     => Mage::helper('cardholder')->__('Invoice #'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'invoice',
      ));

      // $fieldset->addField('stitching_service', 'multiselect', array(
      //     'label'     => Mage::helper('cardholder')->__('Available Stitching Service Types'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'stitching_service',
      //     'values'    => $stitching_service,
      //     'note' => 'This style will be applicable for only selected types',
      // ));

      // $cost_range = $form->getElement('stitching_service');
      // $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('cardholder/adminhtml_cardholder_edit_renderer_pricerange'));
      // $cost_range->setRenderer($this->getLayout()->createBlock('cardholder/adminhtml_cardholder_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getCardholderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCardholderData());
          Mage::getSingleton('adminhtml/session')->getCardholderData(null);
      } elseif ( Mage::registry('cardholder_data') ) {
          $form->setValues(Mage::registry('cardholder_data')->getData());
      }
      return parent::_prepareForm();
  }
}