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
	static $wrapper_data = array();

	public function __construct($id = NULL) {
		
		if($wrapper = e107::getDb()->retrieve("wrapper", "*", "wrapper_id='$id'" ) )
		{
			self::$wrapper_data = $wrapper;
			self::$wrapper_data['wrapper_options'] = e107::unserialize(self::$wrapper_data['wrapper_options']);
		}

	}

	public function getCaption() {
		$caption = e107::pref('wrapper', 'plugin_title'); 
		$caption = varset($title, LAN_WRAPPER_NAME); 
		return $caption;
	}
  
	
	public function getTitle($id)
	{
		$display_title =self::$wrapper_data['wrapper_options']['display_title'];

		if($display_title) 
		{
			$title = self::$wrapper_data['wrapper_title'];

			if(empty($title)) 
			{
				$title = e107::pref('wrapper', 'plugin_title'); 
				$title = varset($title, LAN_WRAPPER_NAME); 
			}
			return $title;
		}
		else return '';
		return $title;
	}

	public function showWrapper($id, $pass)
	{
		// Secure user input
		$id = (int) $id; 
		$wrap_pass = $pass;

		$desc_message  = e107::getParser()->toHTML(e107::pref('wrapper', 'plugin_desc'));
 
		// Check for ID validity - display error if ID is not found in the database
		if(!self::$wrapper_data)
		{
			if(e_DEBUG) 
			return e107::getMessage()->addError(LAN_WRAPPER_ERR2)->render().$desc_message;
			else return $desc_message;
		}

		// Wrapper exists - get all the info
		$wrapper_query 	= self::$wrapper_data;
 
		// Check for userclass access
		if(!check_class($wrapper_query['wrapper_userclass']))
		{

			$restricted_message  = e107::getParser()->toHTML(e107::pref('wrapper', 'message_restricted')); 
			$desc_message = vartrue($restricted_message, $desc_message);

			if(e_DEBUG) 
			return e107::getMessage()->addError(LAN_WRAPPER_ERR3)->render().$desc_message; 
			else return $desc_message;
		}

		// Check if active
		if(!$wrapper_query['wrapper_active'])
		{
			$disabled_message  = e107::getParser()->toHTML(e107::pref('wrapper', 'message_disabled')); 
			$desc_message = vartrue($disabled_message, $desc_message);

			if(e_DEBUG) 
			return e107::getMessage()->addError(LAN_WRAPPER_ERR4)->render().$desc_message; 
			else return $desc_message;
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