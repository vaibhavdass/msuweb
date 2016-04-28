<?php

class Naresh_Sleeves_Block_Adminhtml_Sleeves_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('sleeves_form', array('legend'=>Mage::helper('sleeves')->__('Sleeves Style Information')));

      //$fieldset1 = $form->addFieldset('sleeves_form1', array('legend'=>Mage::helper('sleeves')->__('Sleeves Flat Rates')));

      // $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'stitching_services');
      // if ($attribute->usesSource()) {
      //   $stitching_services = $attribute->getSource()->getAllOptions(false);
      // }

      $attribute1 = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'sleeves_measurement');
      if ($attribute1->usesSource()) {
        $sleeves = $attribute1->getSource()->getAllOptions(false);
      }

      // $fieldset->addField('stitching_service_id', 'select', array(
      //     'label'     => Mage::helper('sleeves')->__('Stitching Service'),
      //     'class'     => 'required-entry',
      //     'required'  => true,
      //     'name'      => 'stitching_service_id',
      //     'values'    => $stitching_services,
      // ));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('sleeves')->__('Sleeve Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      // $fieldset->addField('sleeves_style_id', 'select', array(
      //     'label'     => Mage::helper('sleeves')->__('Style For Sleeves'),
      //     'class'     => 'required-entry',
      //     'name'      => 'sleeves_style_id',
      //     'values'    => $sleeves,
      // ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('sleeves')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('sleeves')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('sleeves')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('sleeves')->__('Image'),
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

      $officehours_field = $fieldset->addField('back_id', 'text', array(
        'name'      => 'back_id',
        'label'     => Mage::helper('sleeves')->__('Available Front Styles'),
        'class'     => 'required-entry',
        'required'  => true,
      ));

      $cost_range = $form->getElement('back_id');
      $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('sleeves/adminhtml_sleeves_edit_renderer_pricerange'));

      $cost_range->setRenderer($this->getLayout()->createBlock('sleeves/adminhtml_sleeves_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getSleevesData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSleevesData());
          Mage::getSingleton('adminhtml/session')->getSleevesData(null);
      } elseif ( Mage::registry('sleeves_data') ) {
          $form->setValues(Mage::registry('sleeves_data')->getData());
      }
      return parent::_prepareForm();
  }
}