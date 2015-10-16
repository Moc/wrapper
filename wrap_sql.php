CREATE TABLE wrap (
  wrap_id int(10) unsigned NOT NULL auto_increment,
  wrap_url text NOT NULL,
  wrap_height smallint(5) unsigned NOT NULL default '0',
  wrap_auto_height enum('Yes','No') NOT NULL default 'Yes',
  wrap_width varchar(4) NOT NULL default '100%',
  wrap_userclass tinyint(3) unsigned NOT NULL default '0',
  wrap_title text NOT NULL,
  wrap_scroll_bars enum('Auto','Yes','No') NOT NULL default 'Auto',
  PRIMARY KEY  (wrap_id)
) TYPE=MyISAM;