<?php
class Naresh_Measurement_Model_Mysql4_Customtitles extends Mage_Core_Model_Mysql4_Abstract {
    public function _construct() {
        // Note that the banner_id refers to the key field in your database table.
        $this->_init('measurement/customtitles', 'custom_title_id');
    }
}
?>