<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>style.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="page">
<div id="header">
        <h1>
            <a href="./"><?php echo $blogname; ?></a><span class="description"><?php echo $bloginfo; ?></span>
        </h1>
	<div id="header_rss">
    	<a href="./rss.php" title="RSS"><img src="<?php echo $em_tpldir; ?>images/button_rss.png" /></a>
    </div>
</div>
<div id="menu">
    <ul>
    <li><span><a href="./index.php">首页</a></span></li>
	<?php if(ISLOGIN): ?>
	<li><a href="./admin/write_log.php">写日志</a></li>
	<li><a href="./admin/">管理中心</a></li>
	<li><a href="./admin/index.php?action=logout">退出</a></li>
	<?php else: ?>
	<li><a href="./admin/index.php">登录</a></li>
	<?php endif; ?>
	 </ul>
    <div id="main_search">
        <form method="get" id="searchform_top" action="index.php">
            <div>
                <input type="text" value="Type your search here..." name="keyword" id="searchform_top_text" onclick="this.value='';" />
                <input type="image" src="<?php echo $em_tpldir; ?>images/button_go.gif" id="gosearch" />
            </div>
        </form>
    </div>
</div>
<div id="body">
<div id="body_top">
	<div id="body_left">
    	<div id="body_left_content">