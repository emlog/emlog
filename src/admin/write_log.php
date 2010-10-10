<?php
/**
 * 显示撰写、编辑日志界面
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

//显示撰写日志页面
if($action == '')
{
	$emTag = new emTag();
	$emSort = new emSort();

	$sorts = $emSort->getSorts();
	$tags = $emTag->getTag();

	$localtime = time() + Option::get('timezone') * 3600;
	$postDate = gmdate('Y-m-d H:i:s', $localtime);

	include View::getView('header');
	require_once View::getView('add_log');
	include View::getView('footer');
	View::output();
}

//显示编辑日志页面
if ($action == 'edit')
{
	$emBlog = new emBlog();
	$emTag = new emTag();
	$emSort = new emSort();

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

	include View::getView('header');
	require_once View::getView('edit_log');
	include View::getView('footer');View::output();
}
