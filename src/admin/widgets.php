<?php
/**
 * Widgets 侧边栏目管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 654 2008-09-07 10:36:15Z emloog $
 */

require_once('./globals.php');


if($action == '')
{
	include getViews('header');
	$result = $DB->query("SELECT widget_list FROM ".DB_PREFIX."config");
	$row    = $DB->fetch_array($result);
	extract($row);
	
	
	//music
	$ismusic = isset($music['ismusic']) && $music['ismusic'] === 1 ? "checked=\"checked\"" : '';
	if(isset($music['auto']) && $music['auto'])
	{
		$auto1 = "checked=\"checked\"";
		$auto2 = '';
	}else{
		$auto2 = "checked=\"checked\"";
		$auto1 = '';		
	}
	if(isset($music['randplay']) && $music['randplay'])
	{
		$randplay1 = "checked=\"checked\"";
		$randplay2 = '';
	}else{
		$randplay2 = "checked=\"checked\"";
		$randplay1 = '';		
	}
	$content = '';
	if(isset($music['mlinks']) && $music['mlinks'])
	{
		foreach($music['mlinks'] as $key=>$val)
		{
			$content .= urldecode($val)."\t".$music['mdes'][$key]."\n";
		}
	}
	
	
	
	require_once(getViews('widgets'));
	include getViews('footer');
	cleanPage();
}

?>