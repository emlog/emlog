<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/dbx.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/print.css" type="text/css" media="print" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="page">
  <div id="wrapper">
    <div id="header">
      <h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname;?></a></h1>
      <div class="description"><?php echo $bloginfo;?></div>
<form method="get" id="searchform" action="<?php echo BLOG_URL; ?>">
<div>
<input type="text" value="Search" name="keyword" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
<input type="submit" id="searchsubmit" value="Go" />
</div>
</form>
</div>
<div id="left-col">	