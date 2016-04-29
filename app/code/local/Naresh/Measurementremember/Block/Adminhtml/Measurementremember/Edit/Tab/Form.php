<?php

class Naresh_Measurementremember_Block_Adminhtml_Measurementremember_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('measurementremember_form', array('legend'=>Mage::helper('measurementremember')->__('Measurementremember Flat Rates')));

      //$fieldset1 = $form->addFieldset('measurementremember_form1', array('legend'=>Mage::helper('measurementremember')->__('Measurementremember Flat Rates')));
     
      // $fieldset->addField('title', 'text', array(
      //     'label'     => Mage::helper('measurementremember')->__('Title'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'title',
      // ));

      // $fieldset->addField('quote_id', 'text', array(
      //     'label'     => Mage::helper('measurementremember')->__('Quote ID'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'quote_id',
      // ));

      // $fieldset->addField('order_id', 'text', array(
      //     'label'     => Mage::helper('measurementremember')->__('Order ID'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'order_id',
      // ));

      // $fieldset->addField('sku', 'text', array(
      //     'label'     => Mage::helper('measurementremember')->__('SKU'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'sku',
      // ));

      // $fieldset->addField('email', 'text', array(
      //     'label'     => Mage::helper('measurementremember')->__('Email'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'email',
      // ));

      // $fieldset->addField('account', 'select', array(
      //     'label'     => Mage::helper('measurementremember')->__('Customer Account'),
      //     'name'      => 'account',
      //     'class'     => 'required-entry',
      //     'values'    => array(
      //         array(
      //             'value'     => 1,
      //             'label'     => Mage::helper('measurementremember')->__('Display in MyAccount'),
      //         ),

      //         array(
      //             'value'     => 0,
      //             'label'     => Mage::helper('measurementremember')->__('Do not Display in MyAccount'),
      //         ),
      //     ),
      // ));

      
      $officehours_field = $fieldset->addField('update_time', 'text', array(
            'name'      => 'update_time',
            'label'     => Mage::helper('measurementremember')->__('Add Custom Options'),
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $custom_titles = $form->getElement('update_time');
        $custom_titles1 = $custom_titles->setRenderer($this->getLayout()->createBlock('measurementremember/adminhtml_measurementremember_edit_renderer_pricerange'));

        $custom_titles->setRenderer($this->getLayout()->createBlock('measurementremember/adminhtml_measurementremember_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getMeasurementrememberData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMeasurementrememberData());
          Mage::getSingleton('adminhtml/session')->getMeasurementrememberData(null);
      } elseif ( Mage::registry('measurementremember_data') ) {
          $form->setValues(Mage::registry('measurementremember_data')->getData());
      }
      return parent::_prepareForm();
  }
}