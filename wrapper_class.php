<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2015-2016 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

class Wrapper
{
	public function getTitle($id)
	{
		$id = (int) $id; 
		$title = e107::getDb()->retrieve('wrapper', 'wrapper_title', 'wrapper_id='.$id);
		return $title;
	}

	public function showWrapper($id, $pass)
	{
		// Secure user input
		$id = (int) $id; 
		$wrap_pass = $pass;

		// Check for ID validity - display error if ID is not found in the database
		if(!e107::getDb()->select("wrapper", "*", "wrapper_id='$id'"))
		{
			return e107::getMessage()->addError(LAN_WRAPPER_ERR2);
		}

		// Wrapper exists - get all the info
		$wrapper_query 	= e107::getDb()->retrieve('wrapper', '*', 'wrapper_id='.$id);

		// Check for userclass access
		if(!check_class($wrapper_query['wrapper_userclass']))
		{
			return e107::getMessage()->addError(LAN_WRAPPER_ERR3); 
		}

		// Convert scrollbars DB value to HTML values used in iframe tag
		$scrollbars = ($wrapper_query['wrapper_scrollbars'] == 1 ? 'yes' : 'no');

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

			$iframe = "<iframe src='".$wrapper_query['wrapper_url'].$wrap_pass."' width='".$width."' height='".$height."' scrolling='".$scrollbars."' frameborder='0'></iframe>";
		}
		// No width and height set, display the iframe fullscreen
		else
		{
			$width  = $wrapper_query['wrapper_width'];
			$height = $wrapper_query['wrapper_height'];
			$iframe = "<iframe src='".$wrapper_query['wrapper_url'].$wrap_pass."' width='100%' style='height: 100em;' scrolling='".$scrollbars."' frameborder='0'></iframe>";
		}

		return $iframe; 
	}
}
