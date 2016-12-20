<?php
/*
 * Wrapper - an e107 plugin by Tijn Kuyper
 *
 * Copyright (C) 2016-2017 Tijn Kuyper (http://www.tijnkuyper.nl)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

require_once('../../class2.php');

e107::lan('wrapper', true, true);

if (!getperms('P'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

class wrapper_adminArea extends e_admin_dispatcher
{
	protected $modes = array(

		'main'	=> array(
			'controller' 	=> 'wrapper_ui',
			'path' 			=> null,
			'ui' 			=> 'wrapper_form_ui',
			'uipath' 		=> null
		),
	);


	protected $adminMenu = array(
		'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = LAN_WRAPPER_NAME;
}


class wrapper_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_WRAPPER_NAME;
		protected $pluginName		= 'wrapper';
	//	protected $eventName		= 'wrapper-wrapper'; // remove comment to enable event triggers in admin.
		protected $table			= 'wrapper';
		protected $pid				= 'wrapper_id';
		protected $perPage			= 10;
		protected $batchDelete		= true;
	//	protected $batchCopy		= true;
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

		protected $listOrder		= 'wrapper_id DESC';

		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'wrapper_id' 			=>  array ( 'title' => LAN_ID, 		'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_title' 		=>  array ( 'title' => LAN_TITLE, 	'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => LAN_WRAPPER_TITLE_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_url' 		=>  array ( 'title' => LAN_URL, 	'type' => 'url', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'validate' => true, 'help' => LAN_WRAPPER_URL_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_height'		=>  array ( 'title' => LAN_WRAPPER_HEIGHT, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => LAN_WRAPPER_HEIGHT_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_width' 		=>  array ( 'title' => LAN_WRAPPER_WIDTH, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => LAN_WRAPPER_WIDTH_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  //'wrapper_auto_height' =>  array ( 'title' => 'Auto height', 'type' => 'boolean', 'data' => 'int', 'width' => 'auto', 'help' => 'Let the plugin choose the appropriate height', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_scrollbars' 	=>  array ( 'title' => LAN_WRAPPER_SCROLLBARS, 'type' => 'boolean', 'data' => 'int', 'width' => 'auto', 'help' =>  LAN_WRAPPER_SCROLLBARS_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'wrapper_userclass'	=>  array ( 'title' => LAN_USERCLASS, 'type' => 'userclass', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'filter' => true, 'help' => LAN_WRAPPER_USERCLASS_HELP, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' 			=>  array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);

		protected $fieldpref = array('wrapper_id', 'wrapper_title', 'wrapper_url', 'wrapper_height', 'wrapper_width', 'wrapper_scrollbars', 'wrapper_userclass');
		// 'wrapper_auto_height',

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		);

		public function init()
		{
			$action	= $this->getAction();
			$id 	= $this->getId();

			if($action == 'edit')
			{
				$title 	 	= e107::getDb()->retrieve('wrapper', 'wrapper_title', 'wrapper_id='.$id);
				$sef_title 	= eHelper::title2sef($title); 
		        
		        $urlparms = array(
		            'wrapper_id' 	=> $id,
		            'wrapper_name'  => $sef_title,
		        );

		        $url = SITEURLBASE.e_PLUGIN_ABS."wrapper/wrapper.php?".$id;
		        $sef_url = SITEURLBASE.e107::url('wrapper', 'wrapper_id', $urlparms);
				
				$link 		= '<a target="_blank" href="'.$url.'">'.$url.'</a>';
				$sef_link 	= '<a target="_blank" href="'.$sef_url.'">'.$sef_url.'</a>';

				$urltext = e107::getParser()->lanVars(LAN_WRAPPER_URL, array($link, $sef_link));
				e107::getMessage()->addInfo($urltext);
			}
		}

		// ------- Customize Create --------
		public function beforeCreate($new_data)
		{
		}

		public function afterCreate($new_data, $old_data, $id)
		{
			$title 	 	= $new_data['wrapper_title'];
			$sef_title 	= eHelper::title2sef($title); 
		        
	        $urlparms = array(
	            'wrapper_id' 	=> $id,
	            'wrapper_name'  => $sef_title,
	       	);
	        
	        $url = SITEURLBASE.e_PLUGIN_ABS."wrapper/wrapper.php?".$id;
	        $sef_url = SITEURLBASE.e107::url('wrapper', 'wrapper_id', $urlparms);
				
			$link 		= '<a target="_blank" href="'.$url.'">'.$url.'</a>';
			$sef_link 	= '<a target="_blank" href="'.$sef_url.'">'.$sef_url.'</a>';
			$urltext = e107::getParser()->lanVars(LAN_WRAPPER_URL, array($link, $sef_link));
			e107::getMessage()->addSuccess($urltext);	
		}

		public function onCreateError($new_data, $old_data)
		{
		}

		// ------- Customize Update --------
		public function beforeUpdate($new_data, $old_data, $id)
		{
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
		}

		public function onUpdateError($new_data, $old_data, $id)
		{
		}
		

	public function renderHelp()
	{
		// documentation
	  	$find    = array('[', ']');
      	$replace = array('<a href="https://github.com/Moc/wrapper/wiki" target="_blank">', '</a>');
     	$text    = str_replace($find, $replace, LAN_WRAPPER_HELP);

		return array(
			'caption'	=> LAN_HELP,
			'text'		=> $text,
		);
	}
}

class wrapper_form_ui extends e_admin_form_ui
{
}

new wrapper_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
