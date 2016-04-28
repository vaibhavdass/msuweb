<?php 
class Lw_Restrict_Model_Resource_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection {

     protected function _beforeLoad() {
         echo "Load!!";
         parent::_beforeLoad();
     }

 }