<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2015-2021 Tijn Kuyper (http://www.tijnkuyper.nl)
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
			return e107::getMessage()->addError(LAN_WRAPPER_ERR2)->render();
		}

		// Wrapper exists - get all the info
		$wrapper_query 	= e107::getDb()->retrieve('wrapper', '*', 'wrapper_id='.$id);
 
		// Check for userclass access
		if(!check_class($wrapper_query['wrapper_userclass']))
		{
			return e107::getMessage()->addError(LAN_WRAPPER_ERR3)->render(); 
		}

		// Convert scrollbars DB value to HTML values used in iframe tag
		$scrollbars = ($wrapper_query['wrapper_scrollbars'] == 1 ? 'yes' : 'no');

		//print_a("w: ".$wrapper_query['wrapper_width']." h:".$wrapper_query['wrapper_height']);
		
		// Specific values set for width and height, nothing special needed
		if($wrapper_query['wrapper_width'] != 0 && $wrapper_query['wrapper_height'] != 0)
		{
			$width = $wrapper_query['wrapper_width'];
			$height = $wrapper_query['wrapper_height'];

			$size = "width='".$width."' height='".$height."'"; 
		}

		// Width = fullscreen, Height = specific 
		if($wrapper_query['wrapper_width'] == 0 && $wrapper_query['wrapper_height'] !== 0)
		{
			$size = "width='100%' height='".$wrapper_query['wrapper_height']."'";
		}

		// Width = specific, Height = fullscreen 
		if($wrapper_query['wrapper_width'] == 0 && $wrapper_query['wrapper_height'] !== 0)
		{
			$size = "width='".$wrapper_query['wrapper_width']."' style='height: 100em;'";
		}

		// Completely fullscreen
		if($wrapper_query['wrapper_width'] == 0 && $wrapper_query['wrapper_height'] == 0)
		{
			$size = "width='100%' style='height: 100em;'";
		}


		$iframe = "<iframe id='wrapper-".$wrapper_query['wrapper_id']."' src='".$wrapper_query['wrapper_url'].$wrap_pass."' ".$size." scrolling='".$scrollbars."' frameborder='0'></iframe>";

		return $iframe;
	}
}