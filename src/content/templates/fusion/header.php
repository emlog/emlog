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
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />

<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
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
              <h1 id="title"><a href="./"><?php echo $blogname; ?></a></h1>


              <!-- top tab navigation -->
              <div id="tabs">
              <ul>

              <!-- homepage tab (remove this section if you dont need it) -->
              <?php if(ISLOGIN): ?>
             	<li class="current_page_item"><a href="./index.php"><span>首页</span></a></li>
				<li class="page_item page-item-2"><a href="./admin/write_log.php"><span>写日志</span></a></li>
				<li class="page_item page-item-2"><a href="./admin/"><span>管理中心</span></a></li>
				<li class="page_item page-item-2"><a href="./admin/index.php?action=logout"><span>退出</span></a></li>
				<?php else: ?>
                <li class="current_page_item"><a href="./index.php"><span>首页</span></a></li>
				<li class="page_item page-item-2"><a href="./admin/index.php"><span>登录</span></a></li>
				<?php endif; ?>
               </ul>
              </div>
              <!-- /top tabs -->

            </div><!-- /header -->
