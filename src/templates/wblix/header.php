<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title><?php echo $blogtitle;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<meta name="description" content="$sitekey" />
	<meta name="keywords" content="emlog,blog,$sitekey" />
	<meta name="copyright" content="emlog" />
	<meta name="author" content="emlog" />

	<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
	<link href="<?php echo $tpl_dir;?>wblix/main.css" rel="stylesheet" type="text/css" />
	<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="container">

<div id="header">
<h1><a href="./"><?php echo $blogname;?></a></h1>
<p><?php echo $bloginfo;?></p>
</div>

<div id="navigation">

<form name="keyform" method="get" action="index.php">
<fieldset>
<input name="keyword" value="" maxlength="30" id="s" />
<input type="submit" value="Go!" id="searchbutton" name="searchbutton" />
</fieldset>
</form>

<ul>
<li class="selected"><a href="./">首页</a></li>
<?php if(ISLOGIN): ?>
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<?php endif; ?>
</ul>

</div>

<hr class="low" />
