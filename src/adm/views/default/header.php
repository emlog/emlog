<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<link href="./views/$nonce_tpl/main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="./views/$nonce_tpl/main.js"></script>
<title>Manager Center</title>
</head>
<body>
<center>
<table id=header cellspacing=0 cellpadding=0 width="100%" border=0>
  <tbody>
  <tr>
    <td width="9" id=headerleft></td>
    <td width=98 align=middle nowrap class="logo">Emlog</td>
    <td class="vesion">$edition</td><td class="vesion">$blogname</td>
    <td align=right nowrap>
	<a href="./index.php">管理中心</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="../index.php" target="_blank">在新窗口浏览blog</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="index.php?action=logout">退出管理</a>&nbsp;&nbsp;&nbsp;&nbsp;	</td>
    <td width="9" id="headerright"></td>
	</tbody>
</table>
<table cellspacing=0 cellpadding=0 width="100%" border=0>
<tbody>
  <tr>
    <td valign=top align=left width=114>
      <table cellspacing=0 cellpadding=0 width="100%" border=0 >
        <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div id=sidebartop></div>
            <div class=sidebarmenu>Blog管理</div>
            <div class=sidebarsubmenu><A href="configure.php">博客设置</A><a href="add_log.php"></a></div>
            <div class=sidebarsubmenu><A href="blogger.php" >个人资料</A><a href="admin_log.php"></a></div>
            <div class=sidebarsubmenu><A href="music.php" >背景音乐</A><a href="admin_log.php"></a></div>
			<div class=sidebarsubmenu><A href="template.php" >模板设置</A><a href="admin_log.php"></a></div>
			<div class=sidebarsubmenu><A href="link.php">友站管理</A><a href="admin_log.php"></a></div> 
			</div>
			</td>
		  </tr>
		</tbody>
	</table>
	      <table cellspacing=0 cellpadding=0 width="100%" border=0>
        <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div id=sidebartop></div>
            <div class=sidebarmenu>日志管理</div>
            <div class=sidebarsubmenu><a href="add_log.php"><img src="./views/$nonce_tpl/images/addblog.gif" align="absbottom" border="0">写日志</a></div>
			<div class=sidebarsubmenu><a href="admin_log.php?pid=draft">草稿<span id="dfnum">$draftnum</span></a></div>
			<div class=sidebarsubmenu><a href="admin_log.php">日志管理</a></div>
            <div class=sidebarsubmenu><A href="comment.php">评论管理</A><a href="admin_log.php"></a></div>
            <div class=sidebarsubmenu><A href="trackback.php">引用管理</A></div>
            <div class=sidebarsubmenu><A href="tag.php">标签管理</A><a href="admin_log.php"></a></div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
	      <table cellspacing=0 cellpadding=0 width="100%" border=0>
        <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div id=sidebartop></div>
            <div class=sidebarmenu>数据管理</div>
            <div class=sidebarsubmenu><A href="backupdata.php">数据备份</A></div>
            <div class=sidebarsubmenu><A href="cache.php">重建缓存</A><a href="admin_log.php"></a></div>
			<div id=sidebarBottom></div></div>
       	    </td>
		  </tr>
		</tbody>
	</table>
</td>
<td id=container valign=top align=left>
<table cellspacing=0 cellpadding=10 width="100%" border=0>
        <tbody>
        <tr>
          <td width="909" align="left" class="tips"><b>小提示：</b>$tips</td>
</tr></tbody></table>
<!--
EOT;
?>-->
