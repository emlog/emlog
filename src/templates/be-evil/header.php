<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="robots" content="index,follow"/>
<meta name="description" content="<?php echo $sitekey;?>" />
<meta name="keywords" content="<?php echo $sitekey;?>" />
<meta name="copyright" content="emlog" />
<meta name="author" content="be-evil" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $tpl_dir;?>be-evil/main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="holder">
<div id="header">
	<div id="siteTitle">
	<ul>
  		<li id="blogname">
			<table width="100%" cellpadding="1" cellspacing="1" border="0" style="line-height:60px;">
				<td width="20%">
					<a href="./"><h1><?php echo $blogname;?></h1></a>
				</td>
				<td width="80%" align="right">	
				 
				</td>
			</table>
		</li>
  		<li id="blogdes">
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;<?php echo $bloginfo;?>  
            <a href="./rss.php"><img src="<?php echo $tpl_dir;?>be-evil/images/rss.png" alt="订阅Rss"/></a> | 
            <a href="./index.php"><img src="<?php echo $tpl_dir;?>be-evil/images/home.png" alt="主页"/></a> |
            <a href="./tag.html"><img src="<?php echo $tpl_dir;?>be-evil/images/tag.png" alt="标签"/></a> |
            <a href="./adm/"><img src="<?php echo $tpl_dir;?>be-evil/images/access.png" alt="后台管理"/></a> 
        </li>
	</ul>
  	</div>
</div>