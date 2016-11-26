<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2016-2017 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// Make this page inaccessible when plugin is not installed.
if (!e107::isInstalled('wrapper'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

// Load required files and set initial variables
e107::lan('wrapper', false, true); 
require_once(e_PLUGIN."wrapper/wrapper_class.php");

$caption = '';
$error = '';
$id = '';
$wrap_pass = '';

require_once(HEADERF);

// Retrieve query and check for wrap_pass
list($id, $wrap_pass) = explode('&amp;wrap_pass=', e_QUERY, 2);

$wrapper = new Wrapper(); 
$caption = $wrapper->getTitle($id);
$text = $wrapper->showWrapper($id, $wrap_pass);

// Render the text
$ns->tablerender($caption, e107::getMessage()->render().$text);
require_once(FOOTERF);
exit;
