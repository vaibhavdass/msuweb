<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `measurement` (
  `measurement_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `dropdown_type` varchar(50) DEFAULT NULL,
  `is_required` smallint(6) NOT NULL DEFAULT '0',
  `sortorder` int(11) DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `min_val` int(3) NOT NULL,
  `max_val` int(3) NOT NULL,
  `difference` float(4,2) NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`measurement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `measurement_custom_titles` (
  `custom_title_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `measurement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`custom_title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 