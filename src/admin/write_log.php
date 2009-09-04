<?php
/**
 * Post writing, editing interface
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');
require_once(EMLOG_ROOT.'/model/C_tag.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');
require_once(EMLOG_ROOT.'/model/C_sort.php');

//Write post page
if($action == '')
{
	$emTag = new emTag($DB);
	$emSort = new emSort($DB);

	$sorts = $emSort->getSorts();
	$tags = $emTag->getTag();

	$localtime = time() - ($timezone - 8) * 3600;
	$postDate = date('Y-m-d H:i:s', $localtime);

	include getViews('header');
	require_once(getViews('add_log'));
	include getViews('footer');
	cleanPage();
}

//Edit blog page
if ($action == 'edit')
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);
	$emSort = new emSort($DB);

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $emBlog->getOneLogForAdmin($logid);
	extract($blogData);
	$sorts = $emSort->getSorts();
	//log tag
	$tags = array();
	foreach ($emTag->getTag($logid) as $val)
	{
		$tags[] = $val['tagname'];
	}
	$tagStr = implode(',', $tags);
	//old tag
	$tags = $emTag->getTag();

	if($allow_remark=='y')
	{
		$ex="checked=\"checked\"";
		$ex2="";
	}else{
		$ex="";
		$ex2="checked=\"checked\"";
	}
	if($allow_tb=='y'){
		$add="checked=\"checked\"";
		$add2="";
	}else{
		$add="";
		$add2="checked=\"checked\"";
	}

	include getViews('header');
	require_once(getViews('edit_log'));
	include getViews('footer');cleanPage();
}
