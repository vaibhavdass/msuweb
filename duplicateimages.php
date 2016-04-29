<?php 
include('app/Mage.php');  
//Mage::App('default');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
error_reporting(E_ALL | E_STRICT);
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
ob_implicit_flush (1);
 
$mediaApi = Mage::getModel("catalog/product_attribute_media_api");
$_products = Mage::getModel('catalog/product')->getCollection();
$i =0;
$total = count($_products);
$count = 0;
foreach($_products as $_prod)
{
    $_product = Mage::getModel('catalog/product')->load($_prod->getId());
    $_md5_values = array();
    $base_image = $_product->getImage();
    if($base_image != 'no_selection') {
        $filepath =  Mage::getBaseDir('media') .'/catalog/product' . $base_image  ;
        if(file_exists($filepath)) { $_md5_values[] = md5(file_get_contents($filepath)); }
    }
    $i ++;

    $_images = $_product->getMediaGalleryImages();
    if(sizeof($_images) > 2){
        echo "processing product $i of $total <br>";
        $val = 0;
        foreach($_images as $_image){
            if($_image->getFile() == $base_image) { continue; }
            $mystring = ''.$_image->getFile().'';
            $findme = $_product->getSku().'_CLP_BPT.jpg.jpg';
            $findme1 = $_product->getSku().'_DRP_ZOM.jpg.jpg';
            $pos = strpos($mystring, $findme);
            $pos1 = strpos($mystring, $findme1);
            if($pos > 0 || $pos1 > 0) { 
            }else{
                $mediaApi->remove($_product->getId(),  $_image->getFile());
                $val = 1;
            }
            $filepath =  Mage::getBaseDir('media') .'/catalog/product' . $_image->getFile()  ;
        }
        if ($val == 1) {
            echo "\r\n removed duplicate image from ".$_product->getSku()."<br>";
        }
    }
     
}
echo "finished removed ".$count." duplicated images"; ?>