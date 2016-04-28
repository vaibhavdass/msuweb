<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `measurement_back_styles` (
  `back_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `stitching_service_id` int(11) NOT NULL,
  `front_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `measurement_attr` text,
  `image` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`back_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 