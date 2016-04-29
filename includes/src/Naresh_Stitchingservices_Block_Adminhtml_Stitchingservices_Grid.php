<?php

class Naresh_Stitchingservices_Block_Adminhtml_Stitchingservices_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('stitchingservicesGrid');
      $this->setDefaultSort('stitchingservices_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stitchingservices/stitchingservices')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('stitchingservices_id', array(
          'header'    => Mage::helper('stitchingservices')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'stitchingservices_id',
      ));

      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      $options = array();
      foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
          if(strlen($option['label']) > 0){
            $options[$option['value']] = $option['label'];
          }
      }
      
      $this->addColumn('stitching_service_id', array(
          'header'    => Mage::helper('stitchingservices')->__('Stitching Service'),
          'align'     =>'left',
          'index'     => 'stitching_service_id',
          'type'      => 'options',
          'options'   => $options,
      ));
      $this->addColumn('title', array(
          'header'    => Mage::helper('stitchingservices')->__('Service Name'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('stitching_service_price', array(
          'header'    => Mage::helper('stitchingservices')->__('Service Price'),
          'align'     =>'left',
          'index'     => 'stitching_service_price',
      ));
      $this->addColumn('weight', array(
          'header'    => Mage::helper('stitchingservices')->__('Service Weight'),
          'align'     =>'left',
          'index'     => 'weight',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('stitchingservices')->__('Status'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('stitchingservices')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('stitchingservices')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
      $this->addColumn('created_time', array(
          'header'    => Mage::helper('stitchingservices')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('stitchingservices')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('stitchingservices')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('stitchingservices')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('stitchingservices_id');
        $this->getMassactionBlock()->setFormFieldName('stitchingservices');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stitchingservices')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stitchingservices')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('stitchingservices/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('stitchingservices')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('stitchingservices')->__('Status'),
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