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
    <link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/style.css" type="text/css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="water-theme" href="<?php echo CERTEMPLATE_URL; ?>/water.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="life-theme" href="<?php echo CERTEMPLATE_URL; ?>/life.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="earth-theme" href="<?php echo CERTEMPLATE_URL; ?>/earth.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="wind-theme" href="<?php echo CERTEMPLATE_URL; ?>/wind.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="fire-theme" href="<?php echo CERTEMPLATE_URL; ?>/fire.css" />
  <link rel="alternate stylesheet" type="text/css" media="handheld,screen" title="lite-theme" href="<?php echo CERTEMPLATE_URL; ?>/lite.css" />
  <link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
    <script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
  
  <!-- IE6 Specific Fixes -->
  <!--[if gte IE 5.5]>
    <![if lt IE 7]>
      <style type="text/css">
       @import url("<?php echo CERTEMPLATE_URL; ?>/ie6style.css");
       .SMsub ul li a:hover{background:#D4EEFC;}
       .SMsgb A {display:block;}
       .SMsgb A:hover{background:#D4EEFC;}
       .SMRtPoCom {cursor:hand;cursor:pointer;background:none;}
        #menuspan {
          position: absolute; left: 0px; bottom: 0px;
        }
        #StartMenu{
          position: absolute; left: 0px; bottom: 30px;
        }
        div#menuspan {
          right: auto; bottom: auto;
          left: expression( ( -0 - menuspan.offsetWidth + ( document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth ) + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
          top: expression( ( -0 - menuspan.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        }
        div#StartMenu {
          /*right: auto; bottom: auto; */
          right: expression( ( -0 - StartMenu.offsetWidth + ( document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth ) + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
          top: expression( ( -30 - StartMenu.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        }
        #sidebar{background:none;border-left:1px #888 solid;}
      </style>
    <![endif]>
  <![endif]-->
<?php default_stylesheet(); time_style(); ?>
<script src="<?php echo CERTEMPLATE_URL; ?>/js/functions.js" type="text/javascript"></script>
<script type="text/javascript">var $sboxtext="开始搜索";</script>
<?php doAction('index_head'); ?>
</head>
<body onclick="BodyClicked();">
<!-- This Clear Tag is Required for IE! -->
<div class="clear"></div>