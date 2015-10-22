<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2015-2016 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

require_once("../../class2.php");

// Make this page inaccessible when plugin is not installed. 
if (!e107::isInstalled('wrapper'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

// Load the LAN files and set initial variables
e107::lan('oweme', false, true); 
$caption = "Wrapper";
$error = ''; 

require_once(HEADERF);

// Retrieve query and check for wrap_pass
list($id, $wrap_pass) = explode('&amp;wrap_pass=', e_QUERY, 2);

if(!empty($wrap_pass)) 
{
	$wrap_pass = '?'.$wrap_pass;
}

// Check for Wrapper ID in the URL. Display error if no ID is found in the URL. 
if(!varset($id))
{
	$error = e107::getMessage()->addError("No Wrapper ID was found, please verify the URL is correct!"); // TODO LAN
}
// Check for ID validity. Display error if ID is not found in the database.
elseif(!$sql->select("wrapper", "*", "wrapper_id='$id'"))
{
	$error = e107::getMessage()->addError("Invalid Wrapper ID, please verify the URL is correct!"); // TODO LAN
}

// If error is found, display error message and exit.
if($error)
{
	$ns->tablerender($caption, e107::getMessage()->render().$text);
	require_once(FOOTERF);
	exit;
}

// Wrapper ID is found, procceed with building the iframe
else
{
	$wrapper_query = $sql->retrieve('wrapper', '*', 'wrapper_id='.$id);
	
	$caption = $wrapper_query['wrapper_title'];

	// Check for userclass access
	if(!check_class($wrapper_query['wrapper_userclass']))
	{
		e107::getMessage()->addError("You are not allowed to view this page!"); // TODO LAN
		$ns->tablerender($caption, e107::getMessage()->render().$text);
		require_once(FOOTERF);
		exit;
	}

	// Check to see if the auto height was selected and if yes, insert the appropriate JS in the footer
	// NOT WORKING ANYMORE DUE TO CHANGING BROWSER STANDARDS. WORK IN PROGRESS. 
	/*if($wrapper_query['wrapper_auto_height'])
	{
		$onload = 'onload="iFrameHeight()"';
		
		e107::js('footer-inline', "
 				function iFrameHeight() {
                        var h = 0;
                        if ( !document.all ) {
                                h = document.getElementById('blockrandom').contentDocument.height;
                                document.getElementById('blockrandom').style.height = h + 60 + 'px';
                        } else if( document.all ) {
                                h = document.frames('blockrandom').document.body.scrollHeight;
                                document.all.blockrandom.style.height = h + 20 + 'px';
                        }
                }
        ");
	}

	<iframe ".$onload." src='{$wrapper_query['wrapper_url']}{$wrap_pass}' id='blockrandom' name='iframe' width='{$wrapper_query['wrapper_width']}%' height='{$wrapper_query['wrapper_height']}' scrolling='{$wrapper_query['wrapper_scroll_bars']}' frameborder='0' marginheight='0' marginwidth='0'><br />".WRAP_4."<a href='{$page}'>".WRAP_5."</a>.<br /></iframe>";
	*/
	
	// Check if width and/or wrapper height is set 
	if(
		isset($wrapper_query['wrapper_width']) ||
		isset($wrapper_query['wrapper_height']) ||
		(isset($wrapper_query['wrapper_height']) && isset($wrapper_query['wrapper_width']))
	  )
	{	
		// Set default width and height, if they are not already defined
		$width  = varsettrue($wrapper_query['wrapper_width'], "100%");
		$height = varsettrue($wrapper_query['wrapper_height'], "800");

		$text = "<iframe src='".$wrapper_query['wrapper_url'].$wrap_pass."' width='".$width."' height='".$height."' frameborder='0'></iframe>"; 
	}
	// No width and height set, display the iframe fullscreen
	else
	{
		$width  = $wrapper_query['wrapper_width'];
		$height = $wrapper_query['wrapper_height'];
		$text = "<iframe src='".$wrapper_query['wrapper_url'].$wrap_pass."' width='100%' style='height: 100em;' frameborder='0'></iframe>"; 
	}
}

// Render the text
$ns->tablerender($caption, e107::getMessage()->render().$text);
require_once(FOOTERF);
exit;