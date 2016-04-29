<?php
    include_once 'app/Mage.php';
    Varien_Profiler::enable();
    Mage::setIsDeveloperMode(true);
    ini_set('display_errors', 1);
    umask(0);

    $store = Mage::app()->getStore()->getId();
    // Mage::log($store,null,'store.log');
    if(!isset($_REQUEST['store'])) { $store = '1'; } else { $store = $_REQUEST['store']; }
    if($store==1) $store_code = "default";
    if($store==2) $store_code = "i_view";
    if(!$store) $store_code = "default";
    Mage::app()->setCurrentStore($store_code);
try{

    $result = array();
 
    if(!isset($_REQUEST['id'])) {
        $id = '';
    }
    else {
        $id = $_REQUEST['id'];
    }
    if(!isset($_REQUEST['qty'])) {
        $qty = '1';
    }
    else { 
        $qty = $_REQUEST['qty'];
    }

    $session = Mage::getSingleton('core/session', array('name'=>'frontend'));
    Mage::app()->getStore()->setStoreId($store);
 
    $product = Mage::getModel('catalog/product')->setStoreId($store)->load($id);
    
    $cart = Mage::helper('checkout/cart')->getCart();
 
    $cart->addProduct($product, $qty);
 
    $session->setLastAddedProductId($product->getId());
    $session->setCartWasUpdated(true);
 
    $cart->save();
 
    $items_in_cart = Mage::helper('checkout/cart')->getSummaryCount();
 
    $layout = Mage::app()->getLayout();
    $layout->getUpdate()
       ->addHandle('default')
        ->load();
    
    $layout->generateXml()
       ->generateBlocks();  
 
    $cart_sidebar_header = $layout->getBlock('cart_sidebar')->toHtml();

    $result['result']="success";
    $result['message']="Product added to cart!";
    $result['items_in_cart'] = $items_in_cart;
    $result['top_cart'] =  $cart_sidebar_header;
 
    echo json_encode($result);
}
catch (Exception $e) {
    $result['result'] = 'error';
    $result['message'] =  $e->getMessage();
    echo json_encode($result);
}
?>