<?php

class Naresh_Measurement_Block_Adminhtml_Measurement_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('measurementGrid');
      $this->setDefaultSort('measurement_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('measurement/measurement')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('measurement_id', array(
          'header'    => Mage::helper('measurement')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'measurement_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('measurement')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      // $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'stitching_services');
      // if ($attribute->usesSource()) {
      //   $options = $attribute->getSource()->getAllOptions(false);
      //   print_r($options);
      // }
      // foreach ($options as $key => $value) {
      //   $values[] = $value['label'];
      // }
      // $this->addColumn('stitching_service_id', array(
      //     'header'    => Mage::helper('measurement')->__('Stitching Service'),
      //     'align'     =>'left',
      //     'index'     => 'stitching_service_id',
      //     'type'      => 'options',
      //     'options'   => $values,
      // ));
      // $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      // $options = array();
      // foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
      //     if(strlen($option['label']) > 0){
      //       $options[$option['value']] = $option['label'];
      //     }
      // }
      // $this->addColumn('stitching_service_id', array(
      //     'header'    => Mage::helper('stitchingservices')->__('Stitching Service'),
      //     'align'     =>'left',
      //     'index'     => 'stitching_service_id',
      //     'type'      => 'options',
      //     'options'   => $options,
      // ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('measurement')->__('Status'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
      $this->addColumn('field_type', array(
          'header'    => Mage::helper('measurement')->__('Field Type'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'field_type',
          'type'      => 'options',
          'options'   => array(
              'dropdown' => 'Dropdown',
              'text_field' => 'TextField',
              'radio' => 'Radio Button',
              'text_area' => 'Text Area',
          ),
      ));
      $this->addColumn('is_required', array(
          'header'    => Mage::helper('measurement')->__('Required'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'is_required',
          'type'      => 'options',
          'options'   => array(
              1 => 'Yes',
              2 => 'No',
          ),
      ));
      $this->addColumn('sortorder', array(
          'header'    => Mage::helper('measurement')->__('Sort Order'),
          'align'     =>'left',
          'index'     => 'sortorder',
      ));
      $this->addColumn('dropdown_type', array(
          'header'    => Mage::helper('measurement')->__('Dropdown Type'),
          'align'     =>'left',
          'index'     => 'dropdown_type',
      ));
      $this->addColumn('min_val', array(
          'header'    => Mage::helper('measurement')->__('Min Value'),
          'align'     =>'left',
          'index'     => 'min_val',
      ));
      $this->addColumn('max_val', array(
          'header'    => Mage::helper('measurement')->__('Max Value'),
          'align'     =>'left',
          'index'     => 'max_val',
      ));
      $this->addColumn('difference', array(
          'header'    => Mage::helper('measurement')->__('Difference'),
          'align'     =>'left',
          'index'     => 'difference',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('measurement')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('measurement')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
      // $this->addColumn('created_time', array(
      //     'header'    => Mage::helper('measurement')->__('Created On'),
      //     'align'     =>'left',
      //     'type'      => 'datetime',
      //     'index'     => 'created_time',
      // ));
      // $this->addColumn('update_time', array(
      //     'header'    => Mage::helper('measurement')->__('Modified On'),
      //     'align'     =>'left',
      //     'type'      => 'datetime',
      //     'index'     => 'update_time',
      // ));
		$this->addExportType('*/*/exportCsv', Mage::helper('measurement')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('measurement')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('measurement_id');
        $this->getMassactionBlock()->setFormFieldName('measurement');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('measurement')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('measurement')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('measurement/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('measurement')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('measurement')->__('Status'),
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