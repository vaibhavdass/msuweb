<?php 
include('app/Mage.php');  
//Mage::App('default');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
error_reporting(E_ALL | E_STRICT);
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
ob_implicit_flush (1);
 
$mediaApi = Mage::getModel("catalog/product_attribute_media_api");
$_products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter(
                    'status',
                    array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                )
                ->joinField('qty',
                     'cataloginventory/stock_item',
                    'qty',
                    'product_id=entity_id',
                    '{{table}}.is_in_stock=1',
                    'left')
                ->addAttributeToFilter('qty', array("gteq" => 1));
$i =0;
$total = sizeof($_products);
$count = 0;
foreach($_products as $_prod) {
    $_product = Mage::getModel('catalog/product')->load($_prod->getId());
    $items = $mediaApi->items($_product->getId());
    if(sizeof($items) > 2){
        Mage::log($_product->getSku(),null,'sku.log');
        foreach($items as $item){
            $mystring = ''.$item['file'].'';
            $findme = $_product->getSku().'_CLP_BPT.jpg.jpg';
            $findme1 = $_product->getSku().'_DRP_ZOM.jpg.jpg';
            $pos = strpos($mystring, $findme);
            $pos1 = strpos($mystring, $findme1);
            if($pos > 0 || $pos1 > 0) { 
            }else{
                $mediaApi->remove($_product->getId(),  $item['file']);
            }
        }
    }else{
        Mage::log($_product->getSku(),null,'sku1.log');
    }
    $count++;
}
echo "finished removed ".$count." duplicated images"; ?>