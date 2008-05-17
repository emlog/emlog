<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
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

	<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
	<link href="{$tpl_dir}wblix/main.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}wblix/main.js" type="text/javascript"></script>
</head>
<body>
<div id="container">

<div id="header">
<h1><a href="./">$blogname</a></h1>
<p>$blog_info</p>
</div>

<div id="navigation">

<form name="keyform" method="get" action="index.php">
<fieldset>
<input name="keyword" value="" maxlength="30" id="s" />
<input name="action" type="hidden" value="search" size="12" />
<input type="submit" value="Go!" id="searchbutton" name="searchbutton" />
</fieldset>
</form>

<ul>
<li class="selected"><a href="./">首页</a></li>
<!--
EOT;
if(ISLOGIN){
echo <<<EOT
-->
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<!--
EOT;
}
echo <<<EOT
-->
</ul>

</div>

<hr class="low" />
<!--
EOT;
?>-->