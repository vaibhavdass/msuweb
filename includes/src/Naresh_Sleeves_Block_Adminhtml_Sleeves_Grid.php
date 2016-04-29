<?php

class Naresh_Sleeves_Block_Adminhtml_Sleeves_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sleevesGrid');
      $this->setDefaultSort('sleeves_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sleeves/sleeves')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sleeves_id', array(
          'header'    => Mage::helper('sleeves')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'sleeves_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('sleeves')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      $options = array();
      foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
          if(strlen($option['label']) > 0){
            $options[$option['value']] = $option['label'];
          }
      }
      $this->addColumn('stitching_service_id', array(
          'header'    => Mage::helper('sleeves')->__('Stitching Service'),
          'align'     =>'left',
          'index'     => 'stitching_service_id',
          'type'      => 'options',
          'options'   => $options,
      ));

      $collection = Mage::getModel('styles/styles')->getCollection()->addFieldToSelect(array('style_id','title'));
      $options1 = array();
      foreach( $collection as $option ) {
          if(strlen($option['style_id']) > 0){
            $options1[$option['style_id']] = $option['title'];
          }
      }
      $this->addColumn('front_id', array(
          'header'    => Mage::helper('sleeves')->__('Front Style'),
          'align'     =>'left',
          'index'     => 'front_id',
          'type'      => 'options',
          'options'   => $options1,
      ));

      $collection1 = Mage::getModel('back/back')->getCollection()->addFieldToSelect(array('back_id','title'));
      $options2 = array();
      foreach( $collection1 as $option ) {
          if(strlen($option['back_id']) > 0){
            $options2[$option['back_id']] = $option['title'];
          }
      }
      $this->addColumn('back_id', array(
          'header'    => Mage::helper('sleeves')->__('Back Style'),
          'align'     =>'left',
          'index'     => 'back_id',
          'type'      => 'options',
          'options'   => $options2,
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('sleeves')->__('Status'),
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
          'header'    => Mage::helper('sleeves')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('sleeves')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('sleeves')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('sleeves')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('sleeves')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('sleeves')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sleeves_id');
        $this->getMassactionBlock()->setFormFieldName('sleeves');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('sleeves')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('sleeves')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('sleeves/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('sleeves')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('sleeves')->__('Status'),
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