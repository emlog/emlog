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
	//$result = $DB->query("SELECT widget_list FROM ".DB_PREFIX."config");
	//$row    = $DB->fetch_array($result);
	//extract($row);
	
	
	
	
	
	require_once(getViews('widgets'));
	include getViews('footer');
	cleanPage();
}

?>