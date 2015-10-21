<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $Source: help.php,v $
|     $Revision: 0.9 $
|     $Date: 2006/03/18 18:30:49 $
|     $Author: 0.9 jmstacey $
|              0.8 SuS $
|              0.7 Juan $
+----------------------------------------------------------------------------+
*/

@include_once(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php");
@include_once(e_PLUGIN."wrap/languages/English.php");

//---------------------------------------------------------------
//              BEGIN CONFIGURATION AREA
//---------------------------------------------------------------

	$helptitle = WRAPHELP_0;

// Help Chapter 1 (Page Title)
	$helpcapt[] = WRAPHELP_1;
	$helptext[] = WRAPHELP_2;
// Help Chapter 2 (Page URL)
	$helpcapt[] = WRAPHELP_3;
	$helptext[] = WRAPHELP_4;
// Help Chapter 3 (Scroll Bars)
	$helpcapt[] = WRAPHELP_5;
	$helptext[] = WRAPHELP_6;
// Help Chapter 4 (Width)
	$helpcapt[] = WRAPHELP_7;
	$helptext[] = WRAPHELP_8;
// Help Chapter 4 (Height)
	$helpcapt[] = WRAPHELP_9;
	$helptext[] = WRAPHELP_10;
// Help Chapter 4 (Auto Height)
	$helpcapt[] = WRAPHELP_11;
	$helptext[] = WRAPHELP_12;
// Help Chapter 4 (Restrict to)
	$helpcapt[] = WRAPHELP_13;
	$helptext[] = WRAPHELP_14;	
// Passing dynamic data
	$helpcapt[] = WRAPHELP_15;
	$helptext[] = WRAPHELP_16;


//---------------------------------------------------------------
//              END OF CONFIGURATION AREA
//---------------------------------------------------------------

	$text2 = "";
	for ($i=0; $i<count($helpcapt); $i++) {
		$text2 .="<b>".$helpcapt[$i]."</b><br />";
	$text2 .=$helptext[$i]."<br /><br />";
	};

$ns -> tablerender($helptitle, $text2);
?>
