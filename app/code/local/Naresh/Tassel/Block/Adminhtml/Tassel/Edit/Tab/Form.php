<?php

class Naresh_Tassel_Block_Adminhtml_Tassel_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('tassel_form', array('legend'=>Mage::helper('tassel')->__('Tassel Style Information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('tassel')->__('Style Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('tassel')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('tassel')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('tassel')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('tassel')->__('Image'),
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
          'label'     => Mage::helper('tassel')->__('Measurement Attributes'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'measurement_attr',
          'values'    => $measurement_attr,
          'note' => 'Selected Measurements will be collect from customer',
      ));

      $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'a27');
      if ($attribute->usesSource()) {
        $stitching_services = $attribute->getSource()->getAllOptions(false);
      }
      array_unshift($stitching_services, "");
      $fieldset->addField('stitching_service_id', 'select', array(
          'label'     => Mage::helper('tassel')->__('Stitching Service'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'stitching_service_id',
          'values'    => $stitching_services,
      ));

      $fieldset->addField('stitching_service', 'multiselect', array(
          'label'     => Mage::helper('tassel')->__('Available Stitching Service Types'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'stitching_service',
          'values'    => $stitching_service,
          'note' => 'This style will be applicable for only selected types',
      ));

      $cost_range = $form->getElement('stitching_service');
      $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('tassel/adminhtml_tassel_edit_renderer_pricerange'));
      $cost_range->setRenderer($this->getLayout()->createBlock('tassel/adminhtml_tassel_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getTasselData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTasselData());
          Mage::getSingleton('adminhtml/session')->getTasselData(null);
      } elseif ( Mage::registry('tassel_data') ) {
          $form->setValues(Mage::registry('tassel_data')->getData());
      }
      return parent::_prepareForm();
  }
}