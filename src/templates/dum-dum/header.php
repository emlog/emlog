<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $sitekey; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="<?php echo $em_tpldir; ?>style.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>ie7.css" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 6]>
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>ie6.css" type="text/css" media="screen" />
<![endif]-->


<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div class="all">
	<div class="header">
		<h1><a href="./"><?php echo $blogname; ?></a></h1>
		<h2><?php echo $bloginfo; ?></h2>
	</div> <!-- HEADER -->
<form name="f" method="post" action="index.php?action=login">
<div class="menu1">
<div class="menu2">
<ul>
<li class="current_page_item"><a href="">首页</a></li>
<?php if(ISLOGIN): ?>
	<li class="nocurrent_page_item"><a href="./adm/add_log.php">写日志</a></li>
	<li class="nocurrent_page_item"><a href="./adm/">管理</a></li>
	<li class="nocurrent_page_item"><a href="./index.php?action=logout">退出</a></li>
<?php
else:
	$login_code=='y'?
	$ckcode= "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"><input name=\"imgcode\" type=\"text\" class=\"input\" style=\"width:40px;\">":
	$ckcode = '';
?>
	<li id="loginfm" style="display:none" class="nocurrent_page_item">
	用户：<input name="user" id="user" type="text" class="input" style="width:80px;"/>
	密码：<input name="pw" type="password"  class="input" style="width:80px;"/>
	<?php echo $ckcode; ?> 
	<input type="submit" value="登录">
	</li>
	<li class="nocurrent_page_item"><a href="javascript:showhidediv('loginfm','user');">登录</a></li>
<?php endif; ?>
</ul>
</div> <!-- MENU 2 -->
</div> <!-- MENU 1 -->
</form>