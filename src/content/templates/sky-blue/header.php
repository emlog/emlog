<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $blogtitle; ?> Powered by emlog</title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="generator" content="emlog" />
<meta name="wumiiVerification" content="55324f55-1f12-445f-9734-c843a7b299f8" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.2.6.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
	<div id="page">
		<div id="header"><!--header start-->
        	<h1><a href="<?php echo BLOG_URL; ?>" title="<?php echo $blogname; ?>"><?php echo $blogname; ?></a></h1>
            <p><?php echo $bloginfo; ?></p>
            <div class="clear"></div>
			<div id="nav">
                <ul>
    				<li><a href="<?php echo BLOG_URL; ?>" title="<?php echo $blogname; ?>">首页</a></li>
					<?php if($istwitter == 'y'):?>
					<li class="page_item"><a href="<?php echo BLOG_URL; ?>t/">碎语</a></li>
					<?php endif;?>
					<?php 
					foreach ($navibar as $key => $val):
						if ($val['hide'] == 'y'){continue;}
						if (empty($val['url'])){$val['url'] = Url::log($key,'page');}
					?>
					<li class="page_item"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
					<?php endforeach;?>
					<?php doAction('navbar', '<li class="page_item">', '</li>'); ?>
					<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
					<li class="page_item"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
					<li class="page_item"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
					<li class="page_item"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
					<?php else: ?>
					<li class="page_item"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
					<?php endif; ?>
                </ul>
        	</div>
		</div><!--header end-->
        <div class="clear"></div>