<?php
/**
 * 编辑日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.1
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');
require_once(EMLOG_ROOT.'/model/C_tag.php');
require_once(EMLOG_ROOT.'/model/C_sort.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');

//显示编辑页面
if ($action=='')
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);
	$emSort = new emSort($DB);

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $emBlog->getOneLog($logid);
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

//修改日志
if($action == 'edit')
{
	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);
	$emTb = new emTrackback($DB);

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$postDate = isset($_POST['postdate']) ? trim($_POST['postdate']) : '';
	$sort = isset($_POST['sort']) ? addslashes(trim($_POST['sort'])) : '';
	$tagstr = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$edittime = isset($_POST['edittime']) ? intval($_POST['edittime']) : '';
	$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
	$pingurl  = isset($_POST['pingurl']) ? addslashes($_POST['pingurl']) : '';
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$allow_tb = isset($_POST['allow_tb']) ? addslashes($_POST['allow_tb']) : '';
	$logid = 	isset($_POST['gid']) ? intval($_POST['gid']) : '';
	$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';

	$unixPostDate = @strtotime($postDate);
	if($unixPostDate === false)
	{
		$unixPostDate = $date;
	}

	$logData = array(
	'title'=>$title,
	'sortid'=>$sort,
	'date'=>$unixPostDate,
	'allow_remark'=>$allow_remark,
	'allow_tb'=>$allow_tb,
	'content'=>$content
	);
	$emBlog->updateLog($logData, $logid);
	//更新tag
	$emTag->updateTag($tagstr, $logid);
	//发送Trackback
	$tbmsg = '';
	if(!empty($pingurl))
	{
		$tbmsg = $emTb->postTrackback($blogurl, $pingurl, $logid, $title, $blogname, $content);
	}

	$CACHE->mc_logtags();
	$CACHE->mc_logsort();
	$CACHE->mc_logatts();
	$CACHE->mc_record();
	$CACHE->mc_tags();
	$CACHE->mc_newlog();
	formMsg( "保存成功\t$tbmsg", "./edit_log.php?gid=$logid", 1);
}
