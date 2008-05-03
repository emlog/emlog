<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
if($action ==''){
		$home_style = 'current_page_item';
		$style = 'page_item';
	}elseif($action =='tag'){
		$home_style = 'page_item';
		$style = 'current_page_item';
	}else{
		$home_style = 'page_item';
		$style = 'page_item';
	}
	
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title>$blogtitle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<meta name="description" content="$sitekey" />
	<meta name="keywords" content="emlog,blog,$sitekey" />
	<meta name="copyright" content="emlog" />
	<meta name="author" content="emlog" />

	<link rel="alternate" type="application/rss+xml" title="¶©ՄϒµĲ©¿ˢ  href="./rss.php">
	<link href="{$tpl_dir}lust/main.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}lust/main.js" type="text/javascript"></script>
</head>
<body onload="sendinfo('$calendar_url','calendar');">
<div id="header"><div class="wrap_center">
	<h1><a href="./">$blogname</a></h1>
</div></div>

<div class="clear"></div>

<div id="menu">
<ul>
	<li class="$home_style"><a href="./" title="Home">Home</a></li>
<!--
EOT;
if(ISLOGIN){
echo <<<EOT
-->
	<li class="page_item"><a href="./adm/add_log.php">写日志</a></li>
	<li class="page_item"><a href="./adm/">管理中心</a></li>
	<li class="page_item"><a href="./index.php?action=logout">退出</a></li>
<!--
EOT;
}
echo <<<EOT
-->
	<li class="rss"><a href="./rss.php" title="Subscribe to Feed">Subscribe to Feed</a></li>
</ul>
</div>

<div class="clear"></div>

<div id="page"><div class="wrap_center"><div class="wrap_float">
<!--
EOT;
?>-->
