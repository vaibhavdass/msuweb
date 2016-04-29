<?php 
	include_once 'app/Mage.php';
    Varien_Profiler::enable();
    Mage::setIsDeveloperMode(true);
    ini_set('display_errors', 1);
    umask(0);

    $query = "UPDATE `eav_entity_store` INNER JOIN `eav_entity_type` ON `eav_entity_type`.`entity_type_id` = `eav_entity_store`.`entity_type_id`
SET `eav_entity_store`.`increment_prefix`='' WHERE `eav_entity_type`.`entity_type_code`='order' AND `eav_entity_store`.`store_id` = '1'";

$resource = Mage::getSingleton('core/resource');
$write = $resource->getConnection('core_write');
$write->query($query);