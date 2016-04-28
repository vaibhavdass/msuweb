<?php

class Naresh_Newaddaction_Block_Adminhtml_Newaddaction_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('newaddactionGrid');
      $this->setDefaultSort('service_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('newaddaction/newaddaction')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('service_id', array(
          'header'    => Mage::helper('newaddaction')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'service_id',
      ));

      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      $options = array();
      foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
          if(strlen($option['label']) > 0){
            $options[$option['value']] = $option['label'];
          }
      }
      
      $this->addColumn('stitching_service_id', array(
          'header'    => Mage::helper('newaddaction')->__('Stitching Service'),
          'align'     =>'left',
          'index'     => 'stitching_service_id',
          'type'      => 'options',
          'options'   => $options,
      ));
      $this->addColumn('title', array(
          'header'    => Mage::helper('newaddaction')->__('Service Name'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('stitching_service_price', array(
          'header'    => Mage::helper('newaddaction')->__('Service Price'),
          'align'     =>'left',
          'index'     => 'stitching_service_price',
      ));
      $this->addColumn('weight', array(
          'header'    => Mage::helper('newaddaction')->__('Service Weight'),
          'align'     =>'left',
          'index'     => 'weight',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('newaddaction')->__('Status'),
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
            'header'    =>  Mage::helper('newaddaction')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('newaddaction')->__('Edit'),
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
          'header'    => Mage::helper('newaddaction')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('newaddaction')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('newaddaction')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('newaddaction')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('service_id');
        $this->getMassactionBlock()->setFormFieldName('newaddaction');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('newaddaction')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('newaddaction')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('newaddaction/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('newaddaction')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('newaddaction')->__('Status'),
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