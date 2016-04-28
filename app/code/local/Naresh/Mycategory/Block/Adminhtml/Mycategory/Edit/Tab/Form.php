<?php

class Naresh_Mycategory_Block_Adminhtml_Mycategory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $fieldset = $form->addFieldset('mycategory_form', array('legend'=>Mage::helper('mycategory')->__('Mycategory Style Information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('mycategory')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('mycategory')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mycategory')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('mycategory')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('sale', 'select', array(
          'label'     => Mage::helper('mycategory')->__('Source Products Type'),
          'name'      => 'sale',
          'values'    => array(
              array(
                  'value'     => 0,
                  'label'     => Mage::helper('mycategory')->__('All Products'),
              ),

              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mycategory')->__('Sale Products'),
              ),
          ),
      ));
      $fieldset->addField('limit', 'text', array(
          'label'     => Mage::helper('mycategory')->__('Max Limit'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'limit',
      ));
      $fieldset->addField('product_type', 'select', array(
          'label'     => Mage::helper('mycategory')->__('Products Type'),
          'name'      => 'product_type',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mycategory')->__('Current Category Products'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('mycategory')->__('All Category Products'),
              ),
          ),
      ));

      $attributes = Mage::getModel('catalog/product')->getAttributes();
      $attributeArray = array();
      foreach($attributes as $a){
        foreach ($a->getEntityType()->getAttributeCodes() as $attributeName) {
          $attribute_details = Mage::getSingleton("eav/config")->getAttribute('catalog_product', $attributeName);
          if(($attribute_details->getIsUserDefined() == 1) && ($attribute_details->getFrontendInput() == 'multiselect' || $attribute_details->getFrontendInput() == 'select')){
            $attributeArray[] = array(
              'title' => $attributeName,
              'label' => $attribute_details->getFrontendLabel()
            );
          }
        }
        break;
      }

      $fieldset->addField('attr1', 'select', array(
          'label'     => Mage::helper('mycategory')->__('Product Attribute 1'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'attr1',
          'values'    => $attributeArray,
          'note' => 'Selected One Attribute',
      ));

      $cost_range = $form->getElement('attr1');
      $cost_range1 = $cost_range->setRenderer($this->getLayout()->createBlock('mycategory/adminhtml_mycategory_edit_renderer_pricerange'));
      $cost_range->setRenderer($this->getLayout()->createBlock('mycategory/adminhtml_mycategory_edit_renderer_pricerange'));

      if ( Mage::getSingleton('adminhtml/session')->getMycategoryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMycategoryData());
          Mage::getSingleton('adminhtml/session')->getMycategoryData(null);
      } elseif ( Mage::registry('mycategory_data') ) {
          $form->setValues(Mage::registry('mycategory_data')->getData());
      }
      return parent::_prepareForm();
  }
}