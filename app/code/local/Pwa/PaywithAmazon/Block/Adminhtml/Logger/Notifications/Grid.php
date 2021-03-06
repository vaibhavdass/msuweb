<?php

/**
 * This file is part of The Official Amazon Payments Magento Extension
 * (c) Pay with Amazon
 * All rights reserved
 *
 * Reuse or modification of this source code is not allowed
 * without written permission from Pay with Amazon
 *
 * @category   Pwa
 * @package    Pwa_PaywithAmazon
 * @copyright  Pay with Amazon
 * @author     Pay with Amazon
 */
class Pwa_PaywithAmazon_Block_Adminhtml_Logger_Notifications_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('amazon_logger_notifications_grid');
        $this->setDefaultSort('creation_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('paywithamazon/log_iopn')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('creation_time', array(
            'header'        => Mage::helper('paywithamazon')->__('Date'),
            'index'         => 'creation_time',
            'type'          => 'datetime',
            'width'         => '150px'
        ));

        $this->addColumn('uuid', array(
            'header'        => Mage::helper('paywithamazon')->__('UUID'),
            'index'         => 'uuid',
            'width'         => '300px'
        ));

        $this->addColumn('notification_type', array(
            'header'        => Mage::helper('paywithamazon')->__('Notification type'),
            'index'         => 'notification_type',
            'type'          => 'options',
            'options'       => Mage::getModel('paywithamazon/lookup_notification_type')->getOptions(),
            'width'         => '200px'
        ));

        $this->addColumn('processing_result', array(
            'header'        => Mage::helper('paywithamazon')->__('Processing result'),
            'index'         => 'processing_result',
            'align'         => 'center',
            'width'         => '100px'
        ));

        $this->addColumn('action', array(
            'header'    => Mage::helper('paywithamazon')->__('Action'),
            'type'      => 'action',
            'align'     => 'center',
            'width'     => '50px',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('paywithamazon')->__('View'),
                    'url'     => array('base' => '*/*/view'),
                    'field'   => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'is_system' => true
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

}
