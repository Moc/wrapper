CREATE TABLE `wrapper` (
  `wrapper_id` int(10) unsigned NOT NULL auto_increment,
  `wrapper_title` varchar(255) NOT NULL,
  `wrapper_url` varchar(255) NOT NULL,
  `wrapper_height` smallint(4) NOT NULL default '0',
  `wrapper_width` tinyint(4) NOT NULL default '100',
  `wrapper_auto_height` tinyint(3) unsigned NOT NULL default '1',
  `wrapper_scroll_bars` tinyint(3) unsigned NOT NULL default '1',
  `wrapper_userclass` tinyint(3) unsigned NOT NULL default '0',
   PRIMARY KEY (`wrapper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;