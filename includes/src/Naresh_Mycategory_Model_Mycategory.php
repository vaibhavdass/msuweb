<?php

class Naresh_Mycategory_Model_Mycategory extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mycategory/mycategory');
    }
    public function saveMultipleFlatrates($data,$id){
        // $model = Mage::getModel('mycategory/flatrates');
        // $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        // //Mage::log($data);
        // for ($i=0; $i < $data['counts']; $i++) { 
        //     $querydata = "INSERT INTO mycategory_flatrates (cat_id , price_from , price_to , type , percentage , style_id) VALUES (".$data['cat_id'].",'".$data['price_from'.$i]."','".$data['price_to'.$i]."','".$data['type'.$i]."','".$data['percentage'.$i]."',".$id.")";
        //     //Mage::log('querydata : '.$querydata);
        //     $write->query($querydata);
        // }
        return 1;
    }
    public function deleteVal($id){
        Mage::log("Id : ".$id);
    }
}