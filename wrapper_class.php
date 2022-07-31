<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2015-2022 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

class Wrapper
{
	public int $id;
	public $errorMessage = '';
	public $frontpageTitle; 
	public $frontpageText; 

	public function __construct(int $id)
	{
		// Set ID property
		$this->id = $id; 

		// Check and set frontpage title
		if(e107::pref('wrapper', 'frontpage_title'))
		{
			$this->frontpageTitle = e107::pref('wrapper', 'frontpage_title');
		}
		// Check and set frontpage title
		if(e107::pref('wrapper', 'frontpage_text'))
		{
			$this->frontpageText = e107::pref('wrapper', 'frontpage_text');
		}

		$this->checkErrors($id);
	}

	private function checkErrors($id)
	{	
		// Check if ID is filled in
		if(empty($id))
		{
			// Check if frontpage title is set. If not set, show error message. Otherwise continue without error message. 
			if($this->frontpageTitle == "")
			{
				$this->errorMessage = LAN_WRAPPER_ERR1; 
				return;
			}	

			return;
		}

		// Check for ID validity - display error if ID is not found in the database
		if(!e107::getDb()->select("wrapper", "*", "wrapper_id='$id'"))
		{
			$this->errorMessage = LAN_WRAPPER_ERR2; 
			return;
		}

		// Wrapper exists - get all the info
		$wrapper_query = e107::getDb()->retrieve('wrapper', '*', 'wrapper_id='.$id);

		// Check for userclass access
		if(!check_class($wrapper_query['wrapper_userclass']))
		{
			$this->errorMessage = LAN_WRAPPER_ERR3; 
			return;
		}

		// Check if wrapper is active
		if(!$wrapper_query['wrapper_active'])
		{
			$this->errorMessage = LAN_WRAPPER_ERR4; 
			return;
		}
	}

	public function getCaption($id)
	{
		// Return LAN_ERROR is error is detected
		if($this->errorMessage)
		{
			return LAN_ERROR;
		}

		// Check if no ID entered, but no errorMessage. Likely there's a frontpage title set. Check, and show that. Otherwise fallback to LAN_ERROR.
		if(empty($id))
		{
			if($this->frontpageTitle)
			{
				return $this->frontpageTitle; 
			}
			else
			{
				return LAN_ERROR;
			}
		}
		
		// No errors, no frontpage title/text, so return wrapper title as stored in DB
		return e107::getDb()->retrieve('wrapper', 'wrapper_title', 'wrapper_id='.$id);
	}

	public function showWrapper($id = '', $wrap_pass = '')
	{
		if($this->errorMessage)
		{
			return e107::getMessage()->addError($this->errorMessage)->render();
		}

		// Check if no ID entered, but no errorMessage. Likely there's a frontpage text set. Check, and show that. Otherwise fallback to LAN_WRAPPER_ERR1.
		if(empty($id))
		{
			if($this->frontpageText)
			{
				return e107::getParser()->toHTML($this->frontpageText, true);
			}
			else
			{
				return e107::getMessage()->addError(LAN_WRAPPER_ERR1)->render();
			}
		}

		// No erorr, wrapper exists - get all the info
		$wrapper_query 	= e107::getDb()->retrieve('wrapper', '*', 'wrapper_id='.$id);

		// Convert scrollbars DB value to HTML values used in iframe tag
		$scrollbars = ($wrapper_query['wrapper_scrollbars'] == 1 ? 'yes' : 'no');

		//print_a("w: ".$wrapper_query['wrapper_width']." h:".$wrapper_query['wrapper_height']);
		
		// Specific values set for width and height, nothing special needed
		if($wrapper_query['wrapper_width'] != 0 && $wrapper_query['wrapper_height'] != 0)
		{
			$width 	= $wrapper_query['wrapper_width'];
			$height = $wrapper_query['wrapper_height'];

			$size 	= "width='".$width."' height='".$height."'"; 
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