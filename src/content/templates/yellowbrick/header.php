<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_header'); ?>
</head>
<body>
<center>
<div id="page">

<div id="header">
	<div id="header_title">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		<span><?php echo $bloginfo; ?></span>	</div>
	<div id="header_search">
	<form id="searchform" style="display:inline;"name="keyform" method="get"  action="<?php echo BLOG_URL; ?>">
		<table cellpadding="3" cellspacing="0" align="right">
			<tr>
				<td>
					Search: 
				</td>
				<td>
					<input name="keyword"  type="text" value="" style="border:#FFCC00 solid 1px;" />
				</td>
				<td>
					<input type="image" class="sub" src="<?php echo CERTEMPLATE_URL; ?>/images/go.png" align="middle" />
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>
<div id="menu">
	<div id="menu_pad">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<a href="<?php echo BLOG_URL; ?>">home</a>
				</td>
				<?php if(ISLOGIN): ?>
				<td width="50">|</td>
				<td>
					<a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a>
				</td>
				<td width="50">|</td>
				<td>
					<a href="<?php echo BLOG_URL; ?>admin/">管理中心</a>
				</td>
				<td width="50">|</td>
				<td>
					<a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a>
				</td>
<?php else: ?>
	<td width="50">|</td>
				<td>
					<a href="<?php echo BLOG_URL; ?>admin/">登录</a>
				</td>
<?php endif; ?>
			</tr>
		</table>
	</div>

</div>