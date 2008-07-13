<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="description" content="<?php echo $sitekey; ?>" />
<meta name="keywords" content="emlog,blog,<?php echo $sitekey; ?>" />
<meta name="copyright" content="emlog" />
<meta name="author" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="<?php echo $tpl_dir; ?>heart/main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="holder">
<div id="header">
  		<p id="blogname"><a href="./"><?php echo $blogname; ?></a></p>
  		<p id="blogdes"><?php echo $bloginfo; ?></p>
		<p id="navbar"><a href="./">Home</a>
					   <a href="./rss.php">RSS</a>
					   <a href="http://www.emlog.net" target="_blank">emlog</a>
		</p>
</div>