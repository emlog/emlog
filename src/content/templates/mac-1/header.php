<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>dbx.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>print.css" type="text/css" media="print" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="page">
  <div id="wrapper">
    <div id="header">
      <h1><a href="./"><?php echo $blogname;?></a></h1>
      <div class="description"><?php echo $bloginfo;?></div>
<form method="get" id="searchform" action="index.php">
<div>
<input type="text" value="Search" name="keyword" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
<input type="submit" id="searchsubmit" value="Go" />
</div>
</form>
</div>
<div id="left-col">	