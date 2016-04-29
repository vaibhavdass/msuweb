<?php

class Naresh_Measurement_Block_Adminhtml_Measurement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('measurement_form', array('legend'=>Mage::helper('measurement')->__('Measurement Flat Rates')));

      //$fieldset1 = $form->addFieldset('measurement_form1', array('legend'=>Mage::helper('measurement')->__('Measurement Flat Rates')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('measurement')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      // $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'a27');
      // if ($attribute->usesSource()) {
      //   $options = $attribute->getSource()->getAllOptions(false);
      // }
      // $fieldset->addField('stitching_service_id', 'select', array(
      //     'label'     => Mage::helper('measurement')->__('Stitching Service'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'stitching_service_id',
      //     'values'    => $options,
      // ));
      $fieldset->addField('is_required', 'select', array(
          'label'     => Mage::helper('measurement')->__('Is Required'),
          'name'      => 'is_required',
          'class'     => 'required-entry',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('measurement')->__('Yes'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('measurement')->__('No'),
              ),
          ),
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('measurement')->__('Status'),
          'name'      => 'status',
          'class'     => 'required-entry',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('measurement')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('measurement')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('sortorder', 'text', array(
          'label'     => Mage::helper('measurement')->__('Sort Order'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'sortorder',
      ));
      $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('measurement')->__('Image'),
            'name'      => 'image',
            'class'     => 'required-entry',
            'note' => '(*.jpg, *.png, *.gif)',
        )); 
      $fieldset->addField('content', 'textarea', array(
          'label'     => Mage::helper('measurement')->__('Content'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'content',
      ));
      $fieldset->addField('field_type', 'select', array(
          'label'     => Mage::helper('measurement')->__('Field Type'),
          'name'      => 'field_type',
          'class'     => 'required-entry',
          'values'    => array(
              'dropdown' => 'Dropdown',
              'text_field' => 'TextField',
              'radio' => 'Radio Button',
              'text_area' => 'Text Area',
          ),
      ));
      $fieldset->addField('dropdown_type', 'select', array(
          'label'     => Mage::helper('measurement')->__('Type'),
          'name'      => 'dropdown_type',
          'class'     => 'required-entry',
          'values'    => array(
              'standard' => 'Standard',
              'custom' => 'Custom',
          ),
      ));
      
      // $fieldset->addField('min_val', 'text', array(
      //     'label'     => Mage::helper('measurement')->__('Min Value'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'min_val',
      // ));
      // $fieldset->addField('max_val', 'text', array(
      //     'label'     => Mage::helper('measurement')->__('Max Value'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'max_val',
      // ));
      // $fieldset->addField('difference', 'text', array(
      //     'label'     => Mage::helper('measurement')->__('Difference'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'difference',
      // ));
      
      
      $officehours_field = $fieldset->addField('custom_titles', 'text', array(
            'name'      => 'custom_titles',
            'label'     => Mage::helper('measurement')->__('Add Custom Options'),
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $custom_titles = $form->getElement('custom_titles');
        $custom_titles1 = $custom_titles->setRenderer($this->getLayout()->createBlock('measurement/adminhtml_measurement_edit_renderer_pricerange'));

        $custom_titles->setRenderer($this->getLayout()->createBlock('measurement/adminhtml_measurement_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getMeasurementData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMeasurementData());
          Mage::getSingleton('adminhtml/session')->getMeasurementData(null);
      } elseif ( Mage::registry('measurement_data') ) {
          $form->setValues(Mage::registry('measurement_data')->getData());
      }
      return parent::_prepareForm();
  }
}