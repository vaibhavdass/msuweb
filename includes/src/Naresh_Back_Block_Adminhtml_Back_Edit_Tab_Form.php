<?php

class Naresh_Back_Block_Adminhtml_Back_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('back_form', array('legend'=>Mage::helper('back')->__('Back Style Information')));

      //$fieldset1 = $form->addFieldset('back_form1', array('legend'=>Mage::helper('back')->__('Back Flat Rates')));

      // $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'stitching_services');
      // if ($attribute->usesSource()) {
      //   $stitching_services = $attribute->getSource()->getAllOptions(false);
      // }

      // $attribute1 = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'back_measurement');
      // if ($attribute1->usesSource()) {
      //   $back = $attribute1->getSource()->getAllOptions(false);
      // }

      // $fieldset->addField('stitching_service_id', 'select', array(
      //     'label'     => Mage::helper('back')->__('Stitching Service'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'stitching_service_id',
      //     'values'    => $stitching_services,
      // ));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('back')->__('Style Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      // $fieldset->addField('back_style_id', 'select', array(
      //     'label'     => Mage::helper('back')->__('Style For Back'),
      //     'class'     => 'required-entry',
      //     'name'      => 'back_style_id',
      //     'values'    => $back,
      // ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('back')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('back')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('back')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('back')->__('Image'),
            'name'      => 'image',
            'class'     => 'required-entry',
            'note' => '(*.jpg, *.png, *.gif)',
      ));
      $measurement_attr = Mage::getModel('measurement/measurement')
                      ->getCollection()
                      ->addFieldtoSelect('measurement_id','value')
                      ->addFieldtoSelect('title','title')
                      ->addFieldtoSelect('title','label')
                      ->addFieldToFilter('status',1)
                      ->setOrder('sortorder', 'ASC');
      $fieldset->addField('measurement_attr', 'multiselect', array(
          'label'     => Mage::helper('styles')->__('Measurement Attributes'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'measurement_attr',
          'values'    => $measurement_attr,
          'note' => 'Selected Measurements will be collect from customer',
      ));

      $officehours_field = $fieldset->addField('front_id', 'text', array(
        'name'      => 'front_id',
        'label'     => Mage::helper('back')->__('Available Front Styles'),
        'class'     => 'required-entry',
        'required'  => true,
      ));

      $cost_range = $form->getElement('front_id');
      $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('back/adminhtml_back_edit_renderer_pricerange'));

      $cost_range->setRenderer($this->getLayout()->createBlock('back/adminhtml_back_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getBackData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBackData());
          Mage::getSingleton('adminhtml/session')->getBackData(null);
      } elseif ( Mage::registry('back_data') ) {
          $form->setValues(Mage::registry('back_data')->getData());
      }
      return parent::_prepareForm();
  }
}