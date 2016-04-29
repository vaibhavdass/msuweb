<?php
class Naresh_Measurement_Model_Customtitles extends Mage_Core_Model_Abstract
{    public function _construct() { 
        parent::_construct();       
        $this->_init('measurement/customtitles');   
    }
    public function saveMultipleCustomtitles($data,$id){
        $customtitles = Mage::getResourceModel('measurement/customtitles_collection')->addFieldToFilter('measurement_id',$id);
        foreach ($customtitles as $value) {
            $all_custom_titles[] = $value['custom_title_id'];
        }
        $size = sizeof($all_custom_titles)+$data['counter']+$data['counts'];
        for ($i=0; $i < $size; $i++) {
            if(empty($data['custom_title_id'.$i])){
                if(isset($data['custom_title'.$i])){
                    $store = array();
                    $store['title'] = $data['custom_title'.$i];
                    $store['measurement_id'] = $id;
                    $model = Mage::getModel('measurement/customtitles')->setData($store)->setId($data['custom_title_id'.$i])->save();
                }
            }else{
                $store = array();
                $key = array_search($data['custom_title_id'.$i], $all_custom_titles);
                $store['custom_title_id'] = $data['custom_title_id'.$i];
                $store['title'] = $data['custom_title'.$i];
                $store['measurement_id'] = $id;
                $model = Mage::getModel('measurement/customtitles')->setId($data['custom_title_id'.$i])->setData($store)->save();
                unset($all_custom_titles[$key]);
            }
        }
        if(!empty($all_custom_titles)){
            foreach ($all_custom_titles as $key) {
                Mage::getModel('measurement/customtitles')->load($key)->delete();
            }
        }
        return 1;
    }
    public function deleteVal($id){
        Mage::getModel('measurement/customtitles')->load($id)->delete();
    }
}