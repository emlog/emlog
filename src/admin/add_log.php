<?php
/**
 * 撰写日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');
require_once(EMLOG_ROOT.'/model/C_tag.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');

if($action == '')
{
	$emTag = new emTag($DB);
	$tags = $emTag->getTag();
	$tagStr = '';
	foreach ($tags as $val)
	{
		$tagStr .=" <a href=\"javascript: inserttag('{$val['tagname']}','tags');\">{$val['tagname']}</a> ";
	}
	include getViews('header');
	require_once(getViews('add_log'));
	include getViews('footer');
	cleanPage();
}

//添加日志
if($action == 'addlog')
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);
	$emTb = new emTrackback($DB);

	$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$blogid = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//如被自动保存为草稿则有blog id号
	$pingurl  = isset($_POST['pingurl']) ? addslashes($_POST['pingurl']) : '';
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$allow_tb = isset($_POST['allow_tb']) ? addslashes($_POST['allow_tb']) : '';

	if($pid == 'draft')
	{
		$ishide='y';
		$ok_msg = '日志成功保存为草稿！';
		$ok_url = 'admin_log.php?pid=draft';
	}else{
		$ishide = 'n';
		$ok_msg = '日志成功发布！';
		$ok_url = 'admin_log.php';
	}
	$postTime = $emBlog->postDate($timezone,intval($_POST['newhour']),intval($_POST['newmin']),intval($_POST['newsec']),intval($_POST['newmonth']),intval($_POST['newday']),intval($_POST['newyear']));

	$logData = array(
	'title'=>$title,
	'date'=>$postTime,
	'allow_remark'=>$allow_remark,
	'allow_tb'=>$allow_tb,
	'content'=>$content,
	'hide'=>$ishide
	);
	if($blogid > 0)//自动保存草稿后
	{
		$emBlog->updateLog($logData, $blogid);
		$logid = $blogid;
	}else{//未保存草稿
		$logid = $emBlog->addlog($logData);
	}
	//写入tag
	if (!empty($tagstring))
	{
		$emTag->addTag($tagstring, $logid);
		$CACHE->mc_tags('tags');
	}
	//发送Trackback
	$tbmsg = '';
	if(!empty($pingurl))
	{
		$tbmsg = $emTb->postTrackback($blogurl, $pingurl, $logid);
	}
	$CACHE->mc_sta('sta');
	$CACHE->mc_record('records');
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_logatts('log_atts');
	formMsg("$ok_msg\t$tbmsg",$ok_url,1);
}
//自动保存
if($action == 'autosave')
{
	$emBlog = new emBlog($DB);

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$logid = isset($_POST['as_logid']) ? intval((trim($_POST['as_logid']))) : '';

	if($logid >= 0)//编辑草稿
	{
		$logData = array('title'=>$title, 'content'=>$content);
		$emBlog->updateLog($logData, $blogid);
		echo "autosave_gid:{$logid}_df:{$dftnum}_";
	}else{
		$logData = array(
		'title'=>$title,
		'date'=>time(),
		'content'=>$content,
		'hide'=>'y',
		'allow_remark'=>'y',
		'allow_tb'=>'y',
		'attcache'=>''
		);
		$logid = $emBlog->addlog($logData);
		$dftnum = $emBlog->getLogNum('y');
		echo "autosave_gid:{$logid}_df:{$dftnum}_";
	}
}
?>
