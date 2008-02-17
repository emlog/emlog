<?php
/**
 * 博客设置
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

require_once('./globals.php');

if($action == ''){
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

	if($login_code=='y'){
			$ex="selected=\"selected\"";
			$ex2="";
	}else{
			$ex1="";
			$ex2="selected=\"selected\"";
	}
	if($comment_code=='y'){
			$ex3="selected=\"selected\"";
			$ex4="";
	}else{
			$ex3="";
			$ex4="selected=\"selected\"";
	}
	if($ischkcomment=='y'){
			$ex5="selected=\"selected\"";
			$ex6="";
	}else{
			$ex5="";
			$ex6="selected=\"selected\"";
	}
	if($istrackback=='y'){
			$ex7="selected=\"selected\"";
			$ex8="";
	}else{
			$ex7="";
			$ex8="selected=\"selected\"";
	}
	if($isurlrewrite=='y'){
			$ex9="selected=\"selected\"";
			$ex10="";
	}else{
			$ex9="";
			$ex10="selected=\"selected\"";
	}
	require_once(getViews('configure'));
	include getViews('footer');
	cleanPage();
}

//update config
if ($action== "mod_config"){
		
	$sitekey  = isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '';
	$blogname = isset($_POST['sitename']) ? addslashes($_POST['sitename'])  : '';
	$blogurl  = isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '';
	$bloginfo = isset($_POST['description']) ? addslashes($_POST['description']) : '';
	$icp      = isset($_POST['icp']) ? addslashes($_POST['icp']):'';
	$index_lognum = isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '';
	$index_comnum = isset($_POST['index_comment_num']) ? intval($_POST['index_comment_num']) : '';
	$index_tagnum = isset($_POST['index_tagnum']) ? intval($_POST['index_tagnum']) : '';
	$timezone     = isset($_POST['timezone']) ? floatval($_POST['timezone']):'';
	$login_code   = $_POST['login_code']   == 'y' ? 'y' : 'n';
	$comment_code = $_POST['comment_code'] == 'y' ? 'y' : 'n';
	$ischkcomment    = $_POST['ischkcomment']    == 'y' ? 'y' : 'n';
	$isurlrewrite = $_POST['isurlrewrite'] == 'y' ? 'y' : 'n';
	$istrackback = $_POST['istrackback'] == 'y' ? 'y' : 'n';
	$exarea       = $_POST['exarea'] ? addslashes($_POST['exarea']) : '';
	$comment_subnum = $_POST['comment_subnum'] ? intval($_POST['comment_subnum']) : '';
	
	if(!function_exists("ImageCreate") && $login_code=='y' || $comment_code=='y' && !function_exists("ImageCreate"))
	{
		formMsg("开启验证码失败!服务器不支持GD库","javascript:history.go(-1);",0);
	}	
	if(substr($blogurl,-1) !='/')
	{
		$blogurl.='/';
	}
	if(strncasecmp($blogurl,'http://',7))//0 if they are equal
	{
		$blogurl = 'http://'.$blogurl;
	}

	$DB->query("UPDATE {$db_prefix}config SET site_key	='$sitekey',blogname ='$blogname',
				blogurl = '$blogurl',
				bloginfo='$bloginfo',icp='$icp',
				index_lognum = $index_lognum,
				index_comnum = $index_comnum,
				index_tagnum = $index_tagnum,
				timezone = $timezone,
				login_code ='$login_code',
				comment_code ='$comment_code',
				isurlrewrite ='$isurlrewrite',
				ischkcomment ='$ischkcomment',
				istrackback ='$istrackback',
				comment_subnum =$comment_subnum,
				exarea='$exarea' "
		);
	$MC->mc_tags('../cache/tags');		
	$MC->mc_comment('../cache/comments');
	$MC->mc_config('../cache/config');
	$MC->mc_record('../cache/records');
	formMsg("博客设置成功","./configure.php",1);
}
//phpinfo()
if($action=='phpinfo'){
	@phpinfo() OR die('phpinfo函数被禁用!');
}
?>