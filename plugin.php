<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2005
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: www.e107coders.org $
|     $Revision: 0.9.1 $
|     $Date: 2006/06/24 18:06:00 $
|     $Author: 0.9.1 jmstacey $
|		       0.9 jmstacey $
|              0.8 SuS $
|              0.7 Juan $
|              0.6 Jeremy2 $
|              0.5 McFly $
|              0.4 McFly $
+----------------------------------------------------------------------------+
*/

if (file_exists(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php")) {
	include_once(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php");
} else {
	include_once(e_PLUGIN."wrap/languages/English.php");
}

// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Wrap";
$eplug_version = "0.9.1";
$eplug_author = WRAPPLUG_1;
$eplug_url = "http://www.e107coders.org";
$eplug_email = "mcfly@e107.org;jeremy@spsy.net;jon@mark87.com";
$eplug_description = WRAPPLUG_2;
$eplug_compatible = "e107 v0.7+";
$eplug_readme = "wrap_readme.txt";	// leave blank if no readme file

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "wrap";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "wrap";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Used shortcode (new in e107 0.7)
$eplug_sc = array("");

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/wrap_32.png";
$eplug_icon_small = $eplug_folder."/images/wrap_16.png";
$eplug_caption =  "Configure wrapper";

// List of preferences -----------------------------------------------------------------------------------------------
//$eplug_prefs = array(
//	"eventpost_admin" => 0
//);

// List of table names --------------------------------------------
$eplug_table_names = array("wrap");

// List of sql requests to create tables --------------------------
$eplug_tables = array(
"CREATE TABLE ".MPREFIX."wrap (
  wrap_id int(10) unsigned NOT NULL auto_increment,
  wrap_url text NOT NULL,
  wrap_height smallint(5) unsigned NOT NULL default '0',
  wrap_auto_height enum('Yes','No') NOT NULL default 'Yes',
  wrap_width varchar(4) NOT NULL default '100%',
  wrap_userclass tinyint(3) unsigned NOT NULL default '0',
  wrap_title text NOT NULL,
  wrap_scroll_bars enum('Auto','Yes','No') NOT NULL default 'Auto',
  PRIMARY KEY  (wrap_id)
) ENGINE=MyISAM;");

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = FALSE;
$eplug_link_name = "";
$eplug_link_url = "";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = WRAPPLUG_3;

$eplug_upgrade_done = WRAPPLUG_4.$eplug_version;


?>	