CREATE TABLE `wrapper` (
	`wrapper_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`wrapper_title` varchar(255) DEFAULT NULL,
	`wrapper_url` varchar(255) NOT NULL,
	`wrapper_height` smallint(4) DEFAULT NULL,
	`wrapper_width` smallint(4) DEFAULT NULL,
	`wrapper_scrollbars` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`wrapper_userclass` tinyint(3) unsigned NOT NULL DEFAULT '0',
	`wrapper_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`wrapper_options` text NOT NULL,
  PRIMARY KEY (`wrapper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
