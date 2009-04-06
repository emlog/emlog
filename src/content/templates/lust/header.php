<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
if($action ==''):
		$home_style = 'current_page_item';
		$style = 'page_item';
	elseif($action =='tag'):
		$home_style = 'page_item';
		$style = 'current_page_item';
	else:
		$home_style = 'page_item';
		$style = 'page_item';
	endif;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="header"><div class="wrap_center">
	<h1><a href="./"><?php echo $blogname;?></a></h1>
</div></div>

<div class="clear"></div>

<div id="menu">
<ul>
	<li class="$home_style"><a href="./" title="Home">Home</a></li>
<?php if(ISLOGIN): ?>
	<li><a href="./admin/write_log.php">写日志</a></li>
	<li><a href="./admin/">管理中心</a></li>
	<li><a href="./admin/index.php?action=logout">退出</a></li>
<?php else: ?>
	<li><a href="./admin/index.php">登录</a></li>
<?php endif; ?>
	<li class="rss"><a href="./rss.php" title="Subscribe to Feed">Subscribe to Feed</a></li>
</ul>
</div>

<div class="clear"></div>

<div id="page"><div class="wrap_center"><div class="wrap_float">