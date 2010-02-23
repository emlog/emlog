<?php
/**
 * 显示撰写、编辑日志界面
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once 'globals.php';
require_once EMLOG_ROOT.'/model/class.blog.php';
require_once EMLOG_ROOT.'/model/class.tag.php';
require_once EMLOG_ROOT.'/model/class.trackback.php';
require_once EMLOG_ROOT.'/model/class.sort.php';

//显示撰写日志页面
if($action == '')
{
	$emTag = new emTag($DB);
	$emSort = new emSort($DB);

	$sorts = $emSort->getSorts();
	$tags = $emTag->getTag();

	$localtime = time() + $timezone * 3600;
	$postDate = gmdate('Y-m-d H:i:s', $localtime);

	include getViews('header');
	require_once getViews('add_log');
	include getViews('footer');
	cleanPage();
}

//显示编辑日志页面
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
	require_once getViews('edit_log');
	include getViews('footer');cleanPage();
}
