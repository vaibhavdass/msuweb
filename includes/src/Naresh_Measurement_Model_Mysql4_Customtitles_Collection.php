	<?php
class Naresh_Measurement_Model_Mysql4_Customtitles_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        parent::_construct();
        $this->_init('measurement/customtitles');
    }

}
?>