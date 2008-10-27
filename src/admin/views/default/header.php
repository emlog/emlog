<?php if(!defined('ADM_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<link href="./views/<?php echo $nonce_tpl; ?>/main.css" type=text/css rel=stylesheet>
<!--<script type="text/javascript" src="../lib/js/jquery/jquery-1.2.6.js"></script>-->
<script type="text/javascript" src="./views/<?php echo $nonce_tpl; ?>/main.js"></script>
<title>Manager Center</title>
</head>
<body>
<center>
<table id=header cellspacing=0 cellpadding=0 width="100%" border=0>
  <tbody>
  <tr>
    <td width="9" id=headerleft></td>
    <td width=98 align=middle nowrap class="logo">Emlog</td>
    <td class="vesion"><?php echo $edition; ?></td><td class="vesion"><?php echo $blogname; ?></td>
    <td align=right nowrap>
	欢迎您：<a href="blogger.php"><?php echo $userData['username'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="configure.php">设置</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="./index.php">管理首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="../index.php" target="_blank">浏览blog</a>&nbsp;&nbsp;|&nbsp;&nbsp;
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
            <div class="sidebarmenu" onclick="showhidediv('blogctlpl');">Blog管理</div>
			<div id="blogctlpl">
            <div class=sidebarsubmenu><a href="widgets.php" >Widgets</a></div>
			<div class=sidebarsubmenu><a href="template.php" >外观模板</a></div>
			<div class=sidebarsubmenu><a href="link.php">友情链接</a></div>
			</div>
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
            <div class="sidebarmenu" onclick="showhidediv('logmg');">日志管理</div>
			<div id="logmg">
            <div class=sidebarsubmenu><a href="add_log.php"><img src="./views/<?php echo $nonce_tpl; ?>/images/addblog.gif" align="absbottom" border="0">写日志</a></div>
			<div class=sidebarsubmenu><a href="admin_log.php?pid=draft">草稿<span id="dfnum"><?php echo $draftnum; ?></span></a></div>
			<div class=sidebarsubmenu><a href="admin_log.php">日志管理</a></div>
            <div class=sidebarsubmenu><A href="tag.php">标签管理</A><a href="admin_log.php"></a></div>
            <div class=sidebarsubmenu><A href="comment.php">评论管理</A><a href="admin_log.php"></a></div>
            <div class=sidebarsubmenu><A href="trackback.php">引用管理</A></div>
			</div>
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
            <div class="sidebarmenu" onclick="showhidediv('datamg');">数据管理</div>
			<div id="datamg">
            <div class=sidebarsubmenu><A href="backupdata.php">数据备份</A></div>
            <div class=sidebarsubmenu><A href="cache.php">重建缓存</A><a href="admin_log.php"></a></div>
			</div>
			<div id=sidebarBottom></div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
</td>
<td id=container valign=top align=left>
<table cellspacing=0 cellpadding=10 width="100%" border=0>
        <tbody>
        <tr>
          <td width="909" align="left" class="tips"><b>小贴士：</b><?php echo $tips; ?></td>
</tr>
</tbody>
</table>