<?php
/**
 * 编辑日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');
require_once(EMLOG_ROOT.'/model/C_tag.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');

//显示编辑页面
if ($action=='')
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $emBlog->getOneLog($logid); 
	extract($blogData);
	//log tag
	$tags = array();
	foreach ($emTag->getTag($logid) as $val)
	{
		$tags[] = $val['tagname'];
	}
	$tagStr = implode(',', $tags);
	//old tag
	$tags = $emTag->getTag();
	$oldTagStr = '';
	foreach ($tags as $val)
	{
		$oldTagStr .=" <a href=\"javascript: inserttag('{$val['tagname']}','tags');\">{$val['tagname']}</a> ";
	}
	//date
	$year = date('Y',$date);
	$month = date('m',$date);
	$day = date('d',$date);
	$hour = date('H',$date);
	$minute = date('i',$date);
	$second	 = date('s',$date);

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

//修改日志
if($action=="edit")
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);
	$emTb = new emTrackback($DB);

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$edittime = isset($_POST['edittime']) ? intval($_POST['edittime']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	$pingurl  = isset($_POST['pingurl']) ? addslashes($_POST['pingurl']) : '';
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$allow_tb = isset($_POST['allow_tb']) ? addslashes($_POST['allow_tb']) : '';
	$logid = 	isset($_POST['gid']) ? intval($_POST['gid']) : '';
	$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';

	//是否修改日期 /生成新的日期码
	if($edittime == 1)
	{
		$postTime = @gmmktime($_POST['newhour'],$_POST['newmin'],$_POST['newsec'],$_POST['newmonth'],$_POST['newday'],$_POST['newyear'])-$timezone*3600;;
		if($postTime === false)
		{
			$postTime = $date;
		}
	}else{
		$postTime = $date;
	}

	$logData = array('title'=>$title,'date'=>$postTime,'allow_remark'=>$allow_remark,'allow_tb'=>$allow_tb,'content'=>$content);
	$emBlog->updateLog($logData, $logid);
	//更新tag
	$emTag->updateTag($tagstring, $logid);
	//发送Trackback
	$tbmsg = '';
	if(!empty($pingurl))
	{
		$tbmsg = $emTb->postTrackback($blogurl, $pingurl, $logid);
	}

	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_logatts('log_atts');
	$CACHE->mc_record('records');
	$CACHE->mc_tags('tags');
	formMsg( "保存成功\t$tbmsg","javascript:history.go(-1);",1);
}
