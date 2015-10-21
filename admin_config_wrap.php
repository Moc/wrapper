<?php
/*
+---------------------------------------------------------------+
|	e107 website system	                                          |
|	e107_plugins/wrap/admin_config.php                            |
|	                                                              |
|	©Steve Dunstan 2001-2005	                                    |
|	http://jalist.com	                                            |
|	stevedunstan@jalist.com	                                      |
|	                                                              |
|	Released under the terms and conditions of the	              |
|	GNU General Public License (http://gnu.org).	                |
+---------------------------------------------------------------+
*/
require_once("../../class2.php");

require_once(e_HANDLER."userclass_class.php");

if (file_exists(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php")) {
	include_once(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php");
} else {
	include_once(e_PLUGIN."wrap/languages/English.php");
}

if (!getperms("P")) {
	header("location:".e_BASE."index.php");
	 exit;
}

require_once(e_ADMIN."auth.php");

// Add a page to wrap 
if(IsSet($_POST['add_wrap'])){
	$title = $_POST['wrap_title'];
	$height = $_POST['wrap_height'];
	$auto_height = $_POST['wrap_auto_height'];
	$width = $_POST['wrap_width'];
	$scroll_bars = $_POST['wrap_scroll_bars'];
	$url = $_POST['wrap_url'];
	$uc = $_POST['wrap_userclass'];
	if($url != ""){
		$sql -> db_Insert("wrap", " '0', '$url', '$height', '$auto_height', '$width', '$uc', '$title', '$scroll_bars' ");
		$sql -> db_Select("wrap", "*", "wrap_url='$url'");
		$row = $sql -> db_Fetch();
		//$message = WRAPCONF_1.SITEURL.$PLUGINS_DIRECTORY."wrap/wrap.php?".$row['wrap_id'].".";
		$message = WRAPCONF_1.e_BASE.e_PLUGIN."wrap/wrap.php?".$row['wrap_id'].".";
	}else{
		$message = WRAPCONF_2;
	}
}

// Update an existing wrapped page
if(IsSet($_POST['update_wrap'])){
	$sql -> db_Update("wrap", "wrap_url='".$_POST['wrap_url']."', wrap_height='".$_POST['wrap_height']."', wrap_userclass='".$_POST['wrap_userclass']."', wrap_title='".$_POST['wrap_title']."' WHERE wrap_id='".$_POST['wrap_id']."' ");

	$sql -> db_Update("wrap", "wrap_url='".$_POST['wrap_url']."', wrap_height='".$_POST['wrap_height']."', wrap_auto_height='".$_POST['wrap_auto_height']."', wrap_width='".$_POST['wrap_width']."', wrap_userclass='".$_POST['wrap_userclass']."', wrap_title='".$_POST['wrap_title']."', wrap_scroll_bars='".$_POST['wrap_scroll_bars']."' WHERE wrap_id='".$_POST['wrap_id']."' ");
	unset($wrap_url, $wrap_height, $wrap_auto_height, $wrap_width, $wrap_userclass, $wrap_scroll_bars, $wrap_title);
	$message = WRAPCONF_3;
}

// Delete wrapped page
if(IsSet($_POST['confirm'])){
	$sql -> db_Delete("wrap", "wrap_id='".$_POST['id']."' ");
	$message = WRAPCONF_4;
}

// Confirm 'delete wrapped page' action
if(IsSet($_GET['delete'])){
	$sql -> db_Select("wrap", "*", "wrap_id='".$_GET['delete']."' ");
	list($wrap_id, $wrap_url, $wrap_height, $wrap_userclass, $wrap_title) = $sql-> db_Fetch();
	
	$text = "<div style='text-align:center'>
<b>".WRAPCONF_5." '$wrap_url' ".WRAPCONF_6."</b>
<br /><br />
<form method='post' action='".e_SELF."'>
<input class='button' type='submit' name='cancel' value='".WRAPCONF_7."' /> 
<input class='button' type='submit' name='confirm' value='".WRAPCONF_8."' /> 
<input type='hidden' name='id' value='{$wrap_id}'>
</form>
</div>";

  $ns -> tablerender(WRAPCONF_8, $text);
	
	require_once(e_ADMIN."footer.php");
	exit;
}

// Cancel 'delete wrapped page' action
if(isset($_POST['cancel'])){
	$message = WRAPCONF_9;
}

// Edit wrapped page
if(isset($_GET['edit'])){
	$sql -> db_Select("wrap", "*", "wrap_id='".$_GET['edit']."' ");
	list($wrap_id, $wrap_url, $wrap_height, $wrap_auto_height, $wrap_width, $wrap_userclass, $wrap_title, $wrap_scroll_bars) = $sql-> db_Fetch();
}

// Display message (successful database entry and so on..)
if(isset($message)){
	$ns -> tablerender(WRAPCONF_21, "<div style='text-align:center'><b>".$message."</b></div>");
}

$wrap_height = ($wrap_height) ? $wrap_height : "200";
$wrap_width = ($wrap_width) ? $wrap_width : "100%";
$wrap_total = $sql -> db_Select("wrap");

// Create the section to add / edit wrapped pages
$text .= "<form method='post' action='".e_SELF."'>
<div style='text-align:center'>
<table class='fborder' style='".ADMIN_WIDTH.";'>
";

if(isset($_GET['edit'])){
	$text .= "<tr><td class='forumheader' colspan='2'>";
	$text .= SITEURL.$PLUGINS_DIRECTORY."wrap/wrap.php?{$wrap_id}";
	$text .= "</td></tr>";
}

$text .= "
<tr>
<td class='forumheader3' style='width:20%'>".WRAPCONF_11."</td>
<td class='forumheader3' style='width:80%'>
<span class='smalltext'>".WRAPCONF_12."</span> 
<input class='tbox' type='text' name='wrap_title' size='60' value='{$wrap_title}' maxlength='200' />
</td>
</tr>

<tr>
<td class='forumheader3' style='width:20%'>".WRAPCONF_13."</td>
<td class='forumheader3' style='width:80%'><span class='smalltext'>".WRAPCONF_14."</span><br />
<input class='tbox' type='text' name='wrap_url' size='60' value='{$wrap_url}' maxlength='200' />
</td>
</tr>

";

// Make Scroll bar inputs
$scroll_bar_options = array('No', 'Yes', 'Auto');
$text .= "
<tr>
<td class='forumheader3' style='width:20'>".WRAPCONF_22."</td>
<td class='forumheader3' style='eidth:80%'>
";

if (empty($wrap_scroll_bars)) {
	$wrap_scroll_bars = 'Auto';
}

foreach ($scroll_bar_options as $option)
{
	if ($wrap_scroll_bars == $option) {
	$text .= "<input name='wrap_scroll_bars' type='radio' class='rbox' value='".$option."' checked />".$option." ";
	}
	else {
	$text .= "<input name='wrap_scroll_bars' type='radio' class='rbox' value='".$option."' />".$option." ";
	}
}
$text .= "
</td>
</tr>

<tr>
<td class='forumheader3' style='width:20%'>".WRAPCONF_23."</td>
<td class='forumheader3' style='width:80%'><span class='smalltext'>".WRAPCONF_24."</span><br />
<input class='tbox' type='text' name='wrap_width' size='5' value='{$wrap_width}' maxlength='5' />
</td>
</tr>

<tr>
<td class='forumheader3' style='width:20%'>".WRAPCONF_15."</td>
<td class='forumheader3' style='width:80%'>
<input class='tbox' type='text' name='wrap_height' size='5' value='{$wrap_height}' maxlength='5' /> px</td>
</tr>
";

// Make Auto Height Input radio boxes
$auto_height_options = array('No', 'Yes');
$text .= "
<tr>
<td class='forumheader3' style='width:20'>".WRAPCONF_25."</td>
<td class='forumheader3' style='eidth:80%'>
";

if (empty($wrap_auto_height)) {
	$wrap_auto_height = 'Yes';
}

foreach ($auto_height_options as $option)
{
	if ($wrap_auto_height == $option) {
	$text .= "<input name='wrap_auto_height' type='radio' class='rbox' value='".$option."' checked />".$option." ";
	}
	else {
	$text .= "<input name='wrap_auto_height' type='radio' class='rbox' value='".$option."' />".$option." ";
	}
}
$text .= "
</td>
</tr>

<tr>
<td class='forumheader3' style='width:20%'>".WRAPCONF_16."</td>
<td class='forumheader3' style='width:80%'>";
$text .= r_userclass("wrap_userclass",$wrap_userclass);
$text .= "</td>
</tr>

<tr>
<td colspan='2' style='text-align:center'>";

if(IsSet($_GET['edit'])){
	$text .= "<br /><input class='button' type='submit' name='update_wrap' value='".WRAPCONF_17."' />
<input type='hidden' name='wrap_id' value='{$wrap_id}'>";
}else{
	$text .= "<br /><input class='button' type='submit' name='add_wrap' value='".WRAPCONF_18."' />";
}

$text .= "
</td></tr></table>
</div></form>
";

$ns -> tablerender("<div style='text-align:left'>".WRAPCONF_20."</div>", $text);

// Show a list of currently wrapped pages

if(!$wrap_total) {
	// No wrapped pages found
  $text = "<div style='text-align:center'><b>".WRAPCONF_10."</b></div>";
} 
else
{
	$text = "<br /><div style='text-align:center'>
	<form method='post' action='".e_SELF."'>
	<table class='fborder' class='fborder' style='".ADMIN_WIDTH.";'>
	<tr align='center' valign='middle'>
	  <td class='fcaption' style='width: 5%; text-align: center;'>ID #</td>
	  <td class='fcaption' style='width: 53%; text-align: left;'>".WRAPCONF_13."</div></td>
	  <td class='fcaption' style='width: 25%; text-align: center;'>".WRAPCONF_11."</div></td>
	  <td class='fcaption' style='width: 7%; text-align: center;'>".WRAPCONF_26."</div></td>
	</tr>";
	$sql -> db_Select("wrap");
	while(list($wrap_id, $wrap_url, $wrap_height, $wrap_auto_height, $wrap_width, $wrap_userclass, $wrap_title, $wrap_scroll_bars) = $sql -> db_Fetch()) {
		$text .= "
	  <tr align='center' valign='middle'>
	  <td class='forumheader3' style='text-align: center;'>$wrap_id</td>
	  <td class='forumheader3' style='text-align: left;'>$wrap_url</td>
	  <td class='forumheader3' style='text-align: center;'>$wrap_title</td>
	  <td class='forumheader3' style='text-align:center'><a href='".e_SELF."?edit=".$wrap_id."'>".ADMIN_EDIT_ICON."</a> <a href='".e_SELF."?delete=".$wrap_id."'>".ADMIN_DELETE_ICON."</a>
	  </td>
	  </tr>
	  <tr><td class='forumheader3' colspan='4'><b>".WRAPCONF_22."</b> $wrap_scroll_bars | <b>".WRAPCONF_23."</b> $wrap_width | <b>".WRAPCONF_15."</b> $wrap_height | <b>".WRAPCONF_25."</b> $wrap_auto_height | <b>".WRAPCONF_16."</b> ".r_userclass_name($wrap_userclass)."</td></tr>
	  <tr><td colspan='4'>&nbsp;</td></tr><tr>
	  ";
	  
	}
	$text .= "</table></form>\n</div><br />";
}
	
$ns -> tablerender("<div style='text-align:left'>".WRAPCONF_19."</div>", $text);
require_once(e_ADMIN."footer.php");

?>