<?php

class Naresh_Back_Block_Adminhtml_Back_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('backGrid');
      $this->setDefaultSort('back_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('back/back')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('back_id', array(
          'header'    => Mage::helper('back')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'back_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('back')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $collection = Mage::getModel('styles/styles')->getCollection()->addFieldToSelect(array('style_id','title'));
      $options1 = array();
      foreach( $collection as $option ) {
          if(strlen($option['style_id']) > 0){
            $options1[$option['style_id']] = $option['title'];
          }
      }

      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      $options = array();
      foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
          if(strlen($option['label']) > 0){
            $options[$option['value']] = $option['label'];
          }
      }

      $this->addColumn('stitching_service_id', array(
          'header'    => Mage::helper('back')->__('Stitching Service'),
          'align'     =>'left',
          'index'     => 'stitching_service_id',
          'type'      => 'options',
          'options'   => $options,
      ));
      $this->addColumn('front_id', array(
          'header'    => Mage::helper('back')->__('Front Style'),
          'align'     =>'left',
          'index'     => 'front_id',
          'type'      => 'options',
          'options'   => $options1,
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('back')->__('Status'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
      $this->addColumn('created_time', array(
          'header'    => Mage::helper('back')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('back')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('back')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('back')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('back')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('back')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('back_id');
        $this->getMassactionBlock()->setFormFieldName('back');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('back')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('back')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('back/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('back')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('back')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}