<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $sitekey; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>

<body>
<div id="header"><div id="ing">
<div id="ing_info"><div id="home"><img src="<?php echo $em_tpldir; ?>images/underone_logo_4.gif" alt="blog" align="absmiddle"/><a href="./"><?php echo $blogname;?></a></div>
<?php echo $bloginfo;?>

</div>
<div>
<form id="searchform" name="keyform" method="get" action="index.php">
<div>
<input name="keyword"  type="text" id="s" value="" />
<input type="submit" id="searchsubmit" value="GO" />
</div>
</form>
</div>
</div>
</div>
<div id="page">
<div id="content">