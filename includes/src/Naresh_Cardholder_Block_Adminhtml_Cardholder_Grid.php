<?php

class Naresh_Cardholder_Block_Adminhtml_Cardholder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('cardholderGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('cardholder/cardholder')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('cardholder')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('cardholder')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      
      $this->addColumn('invoice', array(
          'header'    => Mage::helper('cardholder')->__('Invoice #'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'invoice',
      ));

      $this->addColumn('created_time', array(
          'header'    => Mage::helper('cardholder')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('cardholder')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('cardholder')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('cardholder')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('cardholder')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('cardholder')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('cardholder');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('cardholder')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('cardholder')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('cardholder/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('cardholder')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('cardholder')->__('Status'),
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