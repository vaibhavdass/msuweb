<?php

class Naresh_Lehanga_Block_Adminhtml_Lehanga_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('lehangaGrid');
      $this->setDefaultSort('lehanga_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('lehanga/lehanga')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('lehanga_id', array(
          'header'    => Mage::helper('lehanga')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'lehanga_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('lehanga')->__('Title'),
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
          'header'    => Mage::helper('stitchingservices')->__('Stitching Service'),
          'align'     =>'left',
          'index'     => 'stitching_service_id',
          'type'      => 'options',
          'options'   => $options,
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('lehanga')->__('Status'),
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
          'header'    => Mage::helper('lehanga')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('lehanga')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('lehanga')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('lehanga')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('lehanga')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('lehanga')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('lehanga_id');
        $this->getMassactionBlock()->setFormFieldName('lehanga');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('lehanga')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('lehanga')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('lehanga/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('lehanga')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('lehanga')->__('Status'),
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