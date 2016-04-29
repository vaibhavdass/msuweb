<?php
class Naresh_Taxrate_Model_Mysql4_Flatrates extends Mage_Core_Model_Mysql4_Abstract {
    public function _construct() {
        // Note that the banner_id refers to the key field in your database table.
        $this->_init('taxrate/flatrates', 'id');
    }
}
?>