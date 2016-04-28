<?php

class Naresh_Taxrate_Block_Adminhtml_Taxrate_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('taxrateGrid');
      $this->setDefaultSort('taxrate_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('taxrate/taxrate')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('taxrate_id', array(
          'header'    => Mage::helper('taxrate')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'taxrate_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('taxrate')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('tax_default_perc', array(
          'header'    => Mage::helper('taxrate')->__('Tax Percentage'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'tax_default_perc',
      ));
      $this->addColumn('handling_fee', array(
          'header'    => Mage::helper('taxrate')->__('Handling Fee'),
          'align'     =>'center',
          'width'     => '100px',
          'index'     => 'handling_fee',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('taxrate')->__('Status'),
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
                'header'    =>  Mage::helper('taxrate')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('taxrate')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('taxrate_id');
        $this->getMassactionBlock()->setFormFieldName('taxrate');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('taxrate')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('taxrate')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('taxrate/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('taxrate')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('taxrate')->__('Status'),
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