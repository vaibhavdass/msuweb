<?php
require_once 'Mage/Sales/Block/Order/History.php';
class Naresh_Custom_Block_Order_History extends Mage_Sales_Block_Order_History
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('sales/order/history.phtml');
        $orders = Mage::getResourceModel('sales/order_collection')
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
            ->addFieldToFilter('state', array('in' => Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates()))
            ->setOrder('created_at', 'desc')
        ;
        if($this->getRequest()->getParam('status') == 'all'){

        }elseif(strlen($this->getRequest()->getParam('status')) > 0) {
            $orders->addFieldToFilter('status', array('eq' => $this->getRequest()->getParam('status')));
        }

        $this->setOrders($orders);

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('sales')->__('My Orders'));
    }
}
