<?php 

ini_set('memory_limit', "1024M");
ini_set('max_execution_time', 2400);

$mageFilename = 'app/Mage.php';
 require_once $mageFilename;
 Mage::app()->setCurrentStore(0);
 Mage::app();
//Mage::setIsDeveloperMode(true);
//ini_set('display_errors', 1);

 include 'webservice-xpose.php';
 
 Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID)); 
$collection = Mage::getModel('catalog/product')->getCollection()
				//->addAttributeToFilter('status', array('neq' => 2))
				//->addAttributeToFilter('status', array('neq' => 1))
				->addAttributeToFilter('status', array('eq' => 2))
				->addAttributeToSort('id', 'ASC')
				->setPageSize(5000)
				->setCurPage(1); 
				
//echo $collection->getSelect();exit; //To print the select statement

echo "SKU's removed are -<br/>";		
$mail_content = "SKU's removed are -\n";
$i = 0;

		
foreach($collection as $coll)
{

		$sku = $coll->getSku();
		$prod_id = $coll->getId();
		
		//echo $sku."--";echo $prod_id."<br>";
			
		$_product = Mage::getModel('catalog/product')->load($coll->getId());
		$created = $_product->getCreatedAt();

	
		$today_plus_date = date("Y-m-d", strtotime("-20 days")); //Number of days after making the product disabled.
			$today_plus = strtotime($today_plus_date);
			//echo "---";
			$created = strtotime($created);
			if($today_plus > $created)
			{
				echo $sku."--";echo $prod_id."<br>";
				Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID)); //Required to trick magento into beliving the updates are done from admin panel
				//$proxy = new SoapClient('http://www.mysoresareeudyog.com/api/v2_soap/?wsdl=1');
				//$sessionId = $proxy->login('kushal', '1111111111');
				
				//$result = $proxy->catalogProductDelete($sessionId, $prod_id);
				
				    Mage::register('isSecureArea', true);
					$_product->delete();
					Mage::unregister('isSecureArea');
				
				
				// WebserviceXpose('DeleteSku',$sku);
				
				// $filename = "/home/mysoresa/mysoresareeudyog.com/html/media/product_images/".$sku."_DRP_ZOM.jpg"; //Product Zoom Image
				// unlink($filename);
				// $filename = "/home/mysoresa/mysoresareeudyog.com/html/media/product_images/".$sku."_DRP_PDI.jpg"; //Product Details Page Image
				// unlink($filename);
				
				//echo $sku." - ".$created." - "."<br/>";
				$mail_content .= $sku."\n";
				$i++;
	
			}
			   
}
echo "Records Updated - ".$i;
$mail_content .= "Records Updated - ".$i;
mail('it_magento@mysoresareeudyog.com', 'Cron Job - SKU Removal', $mail_content);



?>