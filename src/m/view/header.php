<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//vot echo '<?xml version="1.0" encoding="UTF-8"?\>';
?>
<!DOCTYPE html>
<html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?=EMLOG_LANGUAGE?>">
<head>
<title><?php echo $site_title; ?></title>
<style type="text/css" id="internalStyle">
body{background-color:#FFFFFF; font-size:14px; margin: 0; padding:0;font-family: Helvetica, Arial, sans-serif;-webkit-text-size-adjust: none;}
a:link,a:visited,a:hover,a:active {text-decoration: none;color:#333;}
#top{background-color:#32598B; padding:10px 8px;}#footer{background-color:#EFEFEF; color:#666666; padding:5px;text-align:center;font-weight:bold;}
#page{text-align:center;font-size:26px; color: #CCCCCC}#page a:link,a:active,a:visited,a:hover{padding:0px 6px;}#m{padding:10px;}
#blogname{font-weight:bold; color:#FFFFFF; font-size:14px;}
#blogname a {text-decoration: none;color:#FFFFFF;}
#navi{background:#EFEFEF; padding:3px 0px; text-align:right;}
.title{font-weight:bold; margin:10px 0px 5px 0px;}.title a:link, a:active,a:visited,a:hover{color:#333360; text-decoration:none}
.info{font-size:12px;color:#999999;}.info2{font-size:12px; border-bottom:#CCCCCC dotted 1px; text-align:right; color:#666666; margin:5px 0px; padding:5px;}
.posttitle{font-size:16px; color:#333; font-weight:bold;}.postinfo{font-size:12px; color: #999999;}
.postcont{border-bottom:1px solid #DDDDDD; padding:12px 0px; margin-bottom:10px;}
.t{font-size:16px; font-weight:bold;}.c{padding:10px;}.l{border-bottom:1px solid #DDDDDD; padding:10px 0px;}.twcont{color:#333; padding-top:12px;}
.twinfo{text-align:right; color:#999999; border-bottom:1px solid #DDDDDD; padding:8px 0px; font-size:12px;}
.comcont{color:#333; padding:6px 0px;}.reply{color:#FF3300; font-size:12px;}
.cominfo{text-align:right; color:#999999; border-bottom:1px solid #DDDDDD; padding:8px 0px;font-size:12px;}
.texts{width:92%; height:200px;}.excerpt{width:92%; height:100px;}
textarea {width: 95%;}
textarea {border: 1px solid #A5ABB3;color: #303C46;}
.delcom{font-size:12px; text-align:right; color:#666666; margin:5px 0px; padding:5px;}
</style>
</head>
<body>
<div id="top">
<div id="blogname"><a href="./"><?php echo Option::get('blogname'); ?></a></div>
</div>
<div id="navi">
<!--vot--><a href="./"><?=lang('home')?></a>
<?php if(Option::get('istwitter') == 'y'): ?>
<!--vot--><a href="./?action=tw"><?=lang('twitters')?></a>
<?php endif;?>
<?php if(ISLOGIN === true): ?>
<!--vot--><a href="./?action=write"><?=lang('post_write')?></a> 
<!--vot--><a href="./?action=logout"><?=lang('logout')?></a>
<?php else:?>
<!--vot--><a href="<?php echo BLOG_URL; ?>m/?action=login"><?=lang('login')?></a>
<?php endif;?>
</div>