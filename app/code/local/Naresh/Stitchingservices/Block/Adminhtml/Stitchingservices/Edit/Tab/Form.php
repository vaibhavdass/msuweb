<?php

class Naresh_Stitchingservices_Block_Adminhtml_Stitchingservices_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('stitchingservices_form', array('legend'=>Mage::helper('stitchingservices')->__('Stitchingservices')));

      $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'a27');
      if ($attribute->usesSource()) {
        $options = $attribute->getSource()->getAllOptions(false);
      }
      $fieldset->addField('stitching_service_id', 'select', array(
          'label'     => Mage::helper('stitchingservices')->__('Stitching Service Category '),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'stitching_service_id',
          'values'    => $options,
      ));
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('stitchingservices')->__('Service Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('stitching_service_price', 'text', array(
          'label'     => Mage::helper('stitchingservices')->__('Service Price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'stitching_service_price',
      ));
      $fieldset->addField('weight', 'text', array(
          'label'     => Mage::helper('stitchingservices')->__('Service Weight'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'weight',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('stitchingservices')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('stitchingservices')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('stitchingservices')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('content', 'textarea', array(
          'label'     => Mage::helper('stitchingservices')->__('Content'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'content',
      ));

      if ( Mage::getSingleton('adminhtml/session')->getStitchingservicesData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getStitchingservicesData());
          Mage::getSingleton('adminhtml/session')->getStitchingservicesData(null);
      } elseif ( Mage::registry('stitchingservices_data') ) {
          $form->setValues(Mage::registry('stitchingservices_data')->getData());
      }
      return parent::_prepareForm();
  }
}