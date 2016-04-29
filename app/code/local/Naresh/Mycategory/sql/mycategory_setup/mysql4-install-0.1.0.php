<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `mycategory` (
  `mycategory_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `attr1` text,
  `attr1_values` text,
  `attr2` text,
  `attr2_values` text,
  `attr3` text,
  `attr3_values` text,
  `attr4` text,
  `attr4_values` text,
  `attr5` text,
  `attr5_values` text,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `image` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`mycategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 