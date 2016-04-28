<?php
class Pwa_PaywithAmazon_Model_Check extends Mage_Checkout_Model_Type_Onepage
{    
    public function checkinstall()
    {
        $prefix = Mage::getConfig()->getTablePrefix();
        
        $exists  = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_easyship_cron', '`'));
        $exists1 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_cart_xml', '`'));
        $exists2 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_api', '`'));
        $exists3 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_exception', '`'));
        $exists4 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_report', '`'));
        $exists5 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_feed', '`'));
        $exists6 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_log_iopn', '`'));
        $exists7 = (boolean) Mage::getSingleton('core/resource')->getConnection('core_write')->showTableStatus(trim($prefix . 'amazon_lop_ship', '`'));
        
        $resource       = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        
        $tableName = $prefix . 'sales_flat_order';
        
        $sales_flat_order = $readConnection->describeTable($tableName);
        $check1           = array_key_exists('tfm_shipment_status', $sales_flat_order);
        $check2           = array_key_exists('easyshipable', $sales_flat_order);
        
        $tableName1 = $prefix . 'sales_flat_order_grid';
        
        $sales_flat_order_grid = $readConnection->describeTable($tableName1);
        $check3                = array_key_exists('tfm_shipment_status', $sales_flat_order_grid);
        
        $order_status       = (boolean) Mage::getConfig()->getNode('global/sales/order/statuses/pay_with_amazon');
        $sales_order_status = Mage::getModel('sales/order_status')->getResourceCollection()->getData();
        
        $easy_aws_hand_max = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_hand_max');
        $easy_aws_hand_min = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_hand_min');
        $easy_aws_hazmat   = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_hazmat');
        $easy_aws_gil      = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_gil');
        $easy_aws_height   = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_height');
        $easy_aws_width    = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_width');
        $easy_aws_length   = (boolean) Mage::getModel('eav/entity_attribute')->getCollection()->addFieldToFilter('attribute_code', 'easy_aws_length');
        
        
        $statuses = array(
            'pay_with_amazon' => Mage::getConfig()->getNode('global/sales/order/statuses/pay_with_amazon')->asArray()
        );
        
        foreach ($statuses as $statusCode => $statusInfo) {
            $statusData = Mage::getModel('sales/order_status')->getCollection()->addFieldToFilter('status', array(
                'equals' => $statusCode
            ))->getFirstItem()->getData();
        }
        
        if ($exists && $exists1 && $exists2 && $exists3 && $exists4 && $exists5 && $exists6 && $exists7 && $check3==1 && $check2==1 && $check1==1 && $order_status && $easy_aws_hand_max && $easy_aws_hand_min && $easy_aws_hazmat && $easy_aws_gil && $easy_aws_height && $easy_aws_width && $easy_aws_length && !empty($statusData)) {
            return 1;
        } else {
            return 0;
            
        }
        
    }
}
