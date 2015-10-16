<?php
/*
+---------------------------------------------------------------+
|	e107 website system
|
|	©Steve Dunstan 2001-2002
|	http://jalist.com
|	stevedunstan@jalist.com
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
require_once("../../class2.php");

if (file_exists(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php")) {
	include_once(e_PLUGIN."wrap/languages/".e_LANGUAGE.".php");
} else {
	include_once(e_PLUGIN."wrap/languages/English.php");
}
require_once(HEADERF);

list($id, $wrap_pass) = explode('&wrap_pass=', e_QUERY, 2);
if (!empty($wrap_pass)) {
	$wrap_pass = '?'.$wrap_pass;
}

if($id == ""){
	header("location:".e_BASE."index.php");
	exit;
}

if(!$sql -> db_Select("wrap", "*",  "wrap_id='$id' ")){
	header("location:".e_BASE."index.php");
	exit;
}else{
	if($row = $sql -> db_Fetch()){
		extract($row);		
//	list($wrap_id, $wrap_url, $wrap_height, $wrap_auto_height, $wrap_width, $wrap_userclass, $wrap_title, $wrap_scroll_bars) = $sql-> db_Fetch();
		if(!check_class($wrap_userclass)){
			$ns -> tablerender(WRAP_1, "<div style='text-align:center'>".WRAP_2."</div>");
			require_once(FOOTERF);
			exit;
		}
		if($wrap_auto_height == 'Yes'){
			$onload = ' onload="iFrameHeight()"';
			?>
			<script language="javascript" type="text/javascript">
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
                </script>
				<?PHP
		}
			$icontent = "<iframe".$onload." src='{$wrap_url}{$wrap_pass}' id='blockrandom' name='iframe' width='{$wrap_width}' height='{$wrap_height}' scrolling='{$wrap_scroll_bars}' frameborder='0' marginheight='0' marginwidth='0'><br />".WRAP_4."<a href='{$page}'>".WRAP_5."</a>.<br /></iframe>";
		if($wrap_title != ""){
			$aj = new textparse;
			$wrap_title = $aj -> tpa($wrap_title, "off");
			$ns -> tablerender($wrap_title, $icontent);
		}else{
			echo ($icontent);
		}
	}
	require_once(FOOTERF);
}

?>