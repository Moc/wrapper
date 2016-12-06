<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2016-2017 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT')) { exit; }

class wrapper_shortcodes extends e_shortcode
{

	function __construct()
	{
		//include_lan(e_PLUGIN.'wrapper/languages/'.e_LANGUAGE.'/'.e_LANGUAGE.'_front.php');
		e107::lan('wrapper', false, true);
	}

	function sc_wrapper($parm='')
	{
		require_once(e_PLUGIN."wrapper/wrapper_class.php");

		$id 	= vartrue($parm['id']);
		$pass 	= vartrue($parm['pass']);

		$wrapper = new Wrapper(); 
		$wrapper = $wrapper->showWrapper($id, $pass);
		return $wrapper;
	}
}