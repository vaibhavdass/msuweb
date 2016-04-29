<?php

class Naresh_Measurementremember_Block_Adminhtml_Measurementremember_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('measurementrememberGrid');
      $this->setDefaultSort('measurementremember_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('measurementremember/measurementremember')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('measurementremember_id', array(
          'header'    => Mage::helper('measurementremember')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'measurementremember_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('measurementremember')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('increment_id', array(
          'header'    => Mage::helper('measurementremember')->__('Order ID'),
          'align'     =>'left',
          'width'     => '100px',
          'index'     => 'increment_id',
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
      $this->addColumn('email', array(
          'header'    => Mage::helper('measurementremember')->__('Customer Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      $this->addColumn('sku', array(
          'header'    => Mage::helper('measurementremember')->__('SKU'),
          'align'     =>'left',
          'index'     => 'sku',
      ));
      
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('measurementremember')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('measurementremember')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		$this->addExportType('*/*/exportCsv', Mage::helper('measurementremember')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('measurementremember')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('measurementremember_id');
        $this->getMassactionBlock()->setFormFieldName('measurementremember');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('measurementremember')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('measurementremember')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('measurementremember/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('measurementremember')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('measurementremember')->__('Status'),
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