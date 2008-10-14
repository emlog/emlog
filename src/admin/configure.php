<?php
/**
 * 博客设置
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');
	$result = $DB->query("SELECT * FROM {$db_prefix}config");
	$row    = $DB->fetch_array($result);
	extract($row);
	$blogname = htmlspecialchars($blogname);
	$bloginfo = htmlspecialchars($bloginfo);
	$blogurl  = htmlspecialchars($blogurl);
	$site_key = htmlspecialchars($site_key);
	$exarea = $exarea;
	$icp = htmlspecialchars($icp);

	if($login_code=='y')
	{
		$ex1="selected=\"selected\"";
		$ex2="";
	}else{
		$ex1="";
		$ex2="selected=\"selected\"";
	}
	if($comment_code=='y')
	{
		$ex3="selected=\"selected\"";
		$ex4="";
	}else{
		$ex3="";
		$ex4="selected=\"selected\"";
	}
	if($ischkcomment=='y')
	{
		$ex5="selected=\"selected\"";
		$ex6="";
	}else{
		$ex5="";
		$ex6="selected=\"selected\"";
	}
	if($istrackback=='y')
	{
		$ex7="selected=\"selected\"";
		$ex8="";
	}else{
		$ex7="";
		$ex8="selected=\"selected\"";
	}
	if($isurlrewrite=='y')
	{
		$ex9="selected=\"selected\"";
		$ex10="";
	}else{
		$ex9="";
		$ex10="selected=\"selected\"";
	}
	if($isgzipenable=='y')
	{
		$ex11="selected=\"selected\"";
		$ex12="";
	}else{
		$ex11="";
		$ex12="selected=\"selected\"";
	}
	require_once(getViews('configure'));
	include getViews('footer');
	cleanPage();
}

//update config
if ($action== "mod_config")
{
	$sitekey  = isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '';
	$blogname = isset($_POST['sitename']) ? addslashes($_POST['sitename'])  : '';
	$blogurl = isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '';
	$bloginfo = isset($_POST['description']) ? addslashes($_POST['description']) : '';
	$icp = isset($_POST['icp']) ? addslashes($_POST['icp']):'';
	$index_lognum = isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '';
	$index_comnum = isset($_POST['index_comment_num']) ? intval($_POST['index_comment_num']) : '';
	$index_twnum = isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : '';
	$comment_subnum = isset($_POST['comment_subnum']) ? intval($_POST['comment_subnum']) : '';
	$timezone = isset($_POST['timezone']) ? floatval($_POST['timezone']) : '';
	$exarea = isset($_POST['exarea']) ? addslashes($_POST['exarea']) : '';
	$login_code   = isset($_POST['login_code']) ? $_POST['login_code'] : 'n';
	$comment_code = isset($_POST['comment_code']) ? $_POST['comment_code'] : 'n';
	$ischkcomment = isset($_POST['ischkcomment']) ? $_POST['ischkcomment'] : 'n';
	$isurlrewrite = isset($_POST['isurlrewrite']) ? $_POST['isurlrewrite'] : 'n';
	$isgzipenable = isset($_POST['isgzipenable']) ? $_POST['isgzipenable'] : 'n';
	$istrackback  = isset($_POST['istrackback']) ? $_POST['istrackback'] : 'n';
	
	if(!function_exists("ImageCreate") && $login_code=='y' || $comment_code=='y' && !function_exists("ImageCreate"))
	{
		formMsg("开启验证码失败!服务器不支持GD库","javascript:history.go(-1);",0);
	}
	if($blogurl && substr($blogurl,-1) !='/')
	{
		$blogurl.='/';
	}
	if($blogurl && strncasecmp($blogurl,'http://',7))//0 if they are equal
	{
		$blogurl = 'http://'.$blogurl;
	}

	$ret = $DB->query("UPDATE {$db_prefix}config SET site_key='$sitekey',blogname ='$blogname',
				blogurl = '$blogurl',
				bloginfo='$bloginfo',icp='$icp',
				index_lognum = $index_lognum,
				index_comnum = $index_comnum,
				index_twnum = $index_twnum,
				timezone = $timezone,
				login_code ='$login_code',
				comment_code ='$comment_code',
				isurlrewrite ='$isurlrewrite',
				isgzipenable ='$isgzipenable',
				ischkcomment ='$ischkcomment',
				istrackback ='$istrackback',
				comment_subnum =$comment_subnum,
				exarea='$exarea' "
				);
	$CACHE->mc_tags('../cache/tags');
	$CACHE->mc_comment('../cache/comments');
	$CACHE->mc_config('../cache/config');
	$CACHE->mc_record('../cache/records');
	$CACHE->mc_twitter('../cache/twitter');
	formMsg("博客设置成功","./configure.php",1);
}
//phpinfo()
if($action=='phpinfo')
{
	@phpinfo() OR die('phpinfo函数被禁用!');
}
?>