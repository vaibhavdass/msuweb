<?php

class Naresh_Mycategory_Block_Adminhtml_Mycategory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('mycategoryGrid');
      $this->setDefaultSort('mycategory_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('mycategory/mycategory')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('mycategory_id', array(
          'header'    => Mage::helper('mycategory')->__('ID'),
          'align'     =>'center',
          'width'     => '80px',
          'index'     => 'mycategory_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('mycategory')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $categories = Mage::getModel('catalog/category')
          ->getCollection()
          ->addAttributeToSelect('*')
          ->addIsActiveFilter();
      
      $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'a27');
      $options = array();
      foreach( $categories as $option ) {
          if($option->getEntityId() > 0){
            $str = '';
            for ($i=2; $i < $option->getLevel(); $i++) { 
              $str .= '- ';
            }
            $options[$option->getEntityId()] = $str.$option->getName();
          }
      }
      $this->addColumn('category', array(
          'header'    => Mage::helper('mycategory')->__('Category'),
          'align'     =>'left',
          'index'     => 'category',
          'type'      => 'options',
          'options'   => $options,
      ));
      $this->addColumn('product_type', array(
          'header'    => Mage::helper('mycategory')->__('Products Type'),
          'align'     =>'left',
          'index'     => 'product_type',
          'type'      => 'options',
          'options'   => array(
              1 => 'Current Category Products',
              2 => 'All Category Products',
          ),
      ));
      $this->addColumn('sale', array(
          'header'    => Mage::helper('mycategory')->__('Sale'),
          'align'     =>'left',
          'index'     => 'sale',
          'type'      => 'options',
          'options'   => array(
              0 => 'All Products',
              1 => 'Sale Products',
          ),
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('mycategory')->__('Status'),
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
          'header'    => Mage::helper('mycategory')->__('Created On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));
      $this->addColumn('update_time', array(
          'header'    => Mage::helper('mycategory')->__('Modified On'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'update_time',
      ));
      $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('mycategory')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('mycategory')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
      ));
		// $this->addExportType('*/*/exportCsv', Mage::helper('mycategory')->__('CSV'));
		// $this->addExportType('*/*/exportXml', Mage::helper('mycategory')->__('XML'));
      return parent::_prepareColumns();
  }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('mycategory_id');
        $this->getMassactionBlock()->setFormFieldName('mycategory');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('mycategory')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('mycategory')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('mycategory/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('mycategory')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('mycategory')->__('Status'),
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