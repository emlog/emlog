<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
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
</head>
<body>
	<div class="main">
		<div class="container">
						<div class="header span-24">
				<div class="intro span-18">
					<div class="intro-wrapper paddings">
													<h1 class="logo"><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
												<span class="slogan"><?php echo $bloginfo; ?></span>
					</div>
				</div>

				<div class="icons span-6 last">
					<div class="paddings">
						<div class="icons-wrapper">
							<a href="<?php echo BLOG_URL; ?>rss.php" title="RSS link"><img src="<?php echo CERTEMPLATE_URL; ?>/images/ico/rss.gif" alt="RSS icon" /></a>
							<a href="<?php echo BLOG_URL; ?>"><img src="<?php echo CERTEMPLATE_URL; ?>/images/ico/home.gif" alt="Home icon" /></a>
						</div>
						
						<div class="search fr">
							<form action="<?php echo BLOG_URL; ?>" method="get" id="srch-frm" name="keyform">
							<div class="search-wrapper">
								<input type="text" value="" class="textfield" name="keyword" id="s" />
							</div>
						</form>						</div>
					</div>
                 
				</div>
			</div>

			<div class="menu span-24">
            <ul class="menu-wrapper">
            <li class="first current_page_item"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
            <?php if(ISLOGIN): ?>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
	<?php else: ?>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
	<?php endif; ?>
	</ul>
			</div>
