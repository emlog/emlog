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
<?php doAction('index_head'); ?>
</head>
<body>
  <!-- page wrappers (100% width) -->
  <div id="page-wrap1">
    <div id="page-wrap2">
      <!-- page (actual site content, custom width) -->
      <div id="page">

        <!-- main wrapper (big left column) -->
        <div id="main-wrap">
          <!-- main (container) -->
          <div id="main" class="with-sidebar">
            <!-- header -->
            <div id="header">

              <div id="topnav" class="description"><?php echo $bloginfo; ?></div>
              <h1 id="title"><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>


              <!-- top tab navigation -->
              <div id="tabs">
				<ul>
					<li class="current_page_item"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
					<?php foreach ($navibar as $key => $val):
					if ($val['hide'] == 'y'){continue;}
					if (empty($val['url'])){$val['url'] = BLOG_URL.'?post='.$key;}
					?>
					<li class="page_item page-item-2"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
					<?php endforeach;?>
					<?php doAction('navbar', '<li class="page_item page-item-2">', '</li>'); ?>
					<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
					<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日</a></li>
					<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">管理中</a></li>
					<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
					<?php else: ?>
					<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
					<?php endif; ?>
				</ul>
              </div>
              <!-- /top tabs -->

            </div><!-- /header -->
