<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `stitchingservices` (
  `stitchingservices_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `stitching_service_id` int(11) NOT NULL,
  `stitching_service_price` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `weight` decimal(6,4) DEFAULT '0.0000',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`stitchingservices_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 