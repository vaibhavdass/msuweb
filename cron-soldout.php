<?php 
$mageFilename = 'app/Mage.php';
 require_once $mageFilename;
 Mage::app();

 Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
$collection = Mage::getModel('catalog/product')->getCollection()
				//->addAttributeToFilter('status', array('neq' => 2))
				//->addAttributeToFilter('status', array('neq' => 1))
				->addAttributeToFilter('status', array('eq' => 1))
				->joinField(
					'is_in_stock',
					'cataloginventory/stock_item',
					'is_in_stock',
					'product_id=entity_id',
					'{{table}}.stock_id=1',
					'left'
				)
				->addAttributeToFilter('is_in_stock', array('eq' => 0))
				->setPageSize(2000)
				->setCurPage(1); 	
//echo $collection->getSelect();exit; //To print the select statement

echo "SKU's changed to disabled are -<br/>";		
$mail_content = "SKU's changed to disabled are -\n";
$i = 0;

		
foreach($collection as $coll)
{
	    //echo "<pre>";
		$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($coll);
	
		//echo  $sku = $coll->getSku();  
		//echo $coll->getSku()."<br>";$i++;continue;
		//if($i == 500) break;
		
		
	if(($qtyStock['backorders']=='0') && ($qtyStock['is_in_stock'] == 0))

	{
		    $sku = $coll->getSku();

			$readnew = Mage::getSingleton('core/resource')->getConnection('core_write');
			$qry2 = "select SI.created_at from sales_flat_order S left join sales_flat_order_item SI on S.entity_id = SI.order_id where sku = '".$sku."' and status not in ('complete', 'canceled') order by SI.created_at desc limit 1";
			$res = $readnew->fetchRow($qry2);
			
			if($res['created_at']) {continue;}
			
			$_product = Mage::getModel('catalog/product')->load($coll->getId());
		   //$collection1 = $qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($coll);
		   /*$orderItems = Mage::getModel('sales/order_item')->getCollection()
			->addAttributeToFilter('sku', $sku)
			 ->setOrder('created_at', 'DESC')
			 ->getAllIds();
			$order_last ="";
			foreach($orderItems as $order_id){
				$orderDet = Mage::getModel('sales/order_item')->load($order_id);
				//print_r($orderDet);exit();
				if($orderDet['created_at']) $order_last = $orderDet['created_at'];
			}*/
			
			$qry2 = "select SI.created_at from sales_flat_order S left join sales_flat_order_item SI on S.entity_id = SI.order_id where sku = '".$sku."' order by SI.created_at desc limit 1";
			$res = $readnew->fetchRow($qry2);			
			$order_last = $res['created_at'];
			//echo $sku."<br/>";

			if($order_last == "")
			{
				$last_date = $_product['updated_at'];
			}
			else $last_date = $order_last;
			//echo $last_date." - ".$sku ."<br/>";continue;
			
			//$today_plus_date = date("Y-m-d", strtotime("-3 days"));
			$today_plus_date = date("Y-m-d", strtotime("-6 hours")); //Number of days after its sold out.
			$today_plus = strtotime($today_plus_date);
			$last_date_time = strtotime($last_date);
			//echo $last_date." - ".$today_plus_date ." - ".$sku ."<br/>";continue;

			// $qry3 = "SELECT a.`added_on`,a.`front_start_date`,a.`front_end_date` FROM `recommend` a, `recommend_details` b WHERE a.`rec_id` = b.`rec_id`  AND b.`product_id` = " .$coll->getId();
			// $res1 = $readnew->fetchRow($qry3);

			// if($res1['added_on']){
			// 	$hourdiff = round((strtotime($res1['front_end_date']) - strtotime($res1['front_start_date']))/3600, 1);
			// 	$hourdiff += 720;
			// 	$today_plus_date1 = date("Y-m-d", strtotime("-".$hourdiff." hours"));
			// 	$today_plus = strtotime($today_plus_date1);
			// 	//$mail_content .= $sku."\n";
			// }

			if($today_plus > $last_date_time)
			{
				Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID)); //Required to trick magento into beliving the updates are done from admin panel
				$_product->setStatus(2)->save();//1 = Enabled 2 = Disabled
				echo $sku."<br/>";
				//echo $last_date." - ".$sku ."<br/>";continue;
				$mail_content .= $sku."\n";
				$i++;
				
			}

   }

	   
}
echo "Records Updated - ".$i;
$mail_content .= "Records Updated - ".$i;
mail('it_magento@mysoresareeudyog.com', 'Cron Job', $mail_content);
?>