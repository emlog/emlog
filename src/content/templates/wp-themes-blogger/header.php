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
    <script type="text/javascript"><!--//--><![CDATA[//><!--

sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);

    //--><!]]></script>
    <!--[if lt IE 7]>
        <script defer type="text/javascript" src="<?php echo CERTEMPLATE_URL; ?>//js/pngfix.js"></script>
    <style type="text/css">
        *html .excrept_in {height: 1%;}
    </style>
    <![endif]-->
</head>
<body>
<body>
    <div id="header">
    <div id="topnav">
        
        <div id="topnav_right">
            <script src="<?php echo CERTEMPLATE_URL; ?>//js/date.js" type="text/javascript"></script>
        </div>
    <div class="clear"></div>
    </div><!-- End Topnav -->
        <div id="header_left">
            <h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
            <p><?php echo $bloginfo; ?></p>
        </div>
        <div id="header_right">
            <div id="top_search">
                <form id="searchform" method="get" name="keyform" action="<?php echo BLOG_URL; ?>">
                <input type="text" value="Search This Site..." name="keyword" id="topsearch" onfocus="if (this.value == 'Search This Site...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search This Site...';}" />
                <input type="submit" id="searchbut" value="GO" /></form>
            </div>
        </div>            
    </div>
    <div id="navbar">
        <div id="navigation">
            <div id="nav_left">
                <ul id="nav">
                <ul>
<?php if(ISLOGIN): ?>
	<li><a href="<?php echo BLOG_URL; ?>">Home</a></li>
	<li  class="cat-item cat-item-1"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li  class="cat-item cat-item-1"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li  class="cat-item cat-item-1"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
<?php else: ?>
	<li><a href="<?php echo BLOG_URL; ?>">Home</a></li>
	<li  class="cat-item cat-item-1"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
<?php endif; ?>
</ul>
          </div>
            <div id="nav_right">
                        <a href="<?php echo BLOG_URL; ?>rss.php" target="_blank">Subscribe to RSS</a>
                <a href="<?php echo BLOG_URL; ?>rss.php" target="_blank"><img style="vertical-align:middle" src="<?php echo CERTEMPLATE_URL; ?>/images/rss.png" alt="订阅Rss"/></a>
                    </div>
        <div class="clear"></div>
        </div>
    </div><!-- Header End Here -->        <div id="content">
            <div id="postarea">