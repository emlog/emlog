<?php
/*
Sidebar Amount:2
*/
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
<link href="<?php echo CERTEMPLATE_URL; ?>/style.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CERTEMPLATE_URL; ?>/ie7-style.css" />
	<![endif]-->
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CERTEMPLATE_URL; ?>/ie-style.css" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/mobile.css" type="text/css" media="handheld" />
	<style type="text/css">
		@import url(<?php echo CERTEMPLATE_URL; ?>/mobile.css) screen and (max-width:801px);
	</style>
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>

	<div id="header">
		<h1><a href="./"><?php echo $blogname; ?></a></h1>
		<div class="description"><?php echo $bloginfo; ?></div>
	</div>
		<ul id="navigation">
			<?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = './?post='.$key;}
			?>
			<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
			<?php endforeach;?>
			<?php doAction('navbar', '<li>', '</li>'); ?>
		</ul>
