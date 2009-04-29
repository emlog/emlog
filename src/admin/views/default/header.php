<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<link href="./views/<?php echo ADMIN_TPL; ?>/css-main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../lib/js/jquery/jquery-1.2.6.js"></script>
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
<?php doAction('adm_head');?>
<title><?php echo $blogname; ?> - 管理中心</title>
</head>
<body>
<center>
<table id=header cellspacing=0 cellpadding=0 width="99%" border=0>
  <tbody>
  <tr>
    <td width="9" id=headerleft></td>
    <td width=98 align=middle nowrap class="logo"><a href="./index.php" title="返回管理首页">emlog</a></td>
    <td class="vesion"><?php echo EMLOG_VERSION; ?></td>
    <td class="headtext"><a href="../index.php" target="_blank" title="在新窗口浏览我的blog"><?php echo $blogname; ?></a></td>
    <td align=right nowrap class="headtext">
	你好：<a href="blogger.php" title="点击修改个人资料"><?php if($userData['nickname']):echo $userData['nickname'];else:echo $userData['username'];endif;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="template.php" ><img src="./views/<?php echo ADMIN_TPL; ?>/images/skin.gif" style="margin:2px 0px 3px;" align="absbottom" border="0"> 换模板</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="configure.php">博客设置</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="./index.php">管理首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="index.php?action=logout">退出</a>&nbsp;&nbsp;&nbsp;&nbsp;	</td>
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
            <div class="sidebarmenu" onclick="displayToggle('blogctlpl');">博客管理</div>
			<div id="blogctlpl">
            <div class="sidebarsubmenu"><a href="widgets.php" >Widgets</a></div>
			<div class="sidebarsubmenu"><a href="page.php" >页面</a></div>
			<div class="sidebarsubmenu"><a href="link.php">链接</a></div>
			<div class="sidebarsubmenu"><a href="user.php" >用户</a></div>
			<div class="sidebarsubmenu"><a href="backup.php">数据</a></div>
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
            <div class="sidebarmenu" onclick="displayToggle('logmg');">日志管理</div>
			<div id="logmg">
            <div class="sidebarsubmenu"><a href="write_log.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/addblog.gif" align="absbottom" border="0">写日志</a></div>
			<div class="sidebarsubmenu"><a href="admin_log.php?pid=draft">草稿<span id="dfnum"><?php echo $draftnum == 0 ? '' : '('.$draftnum.')'; ?></span></a></div>
			<div class="sidebarsubmenu"><a href="admin_log.php">日志</a></div>
            <div class="sidebarsubmenu"><a href="tag.php">标签</a></div>
            <div class="sidebarsubmenu"><a href="sort.php">分类</a></div>
            <div class="sidebarsubmenu"><a href="comment.php">评论</a></div>
            <div class="sidebarsubmenu"><a href="trackback.php">引用</a></div>
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
            <div class="sidebarmenu" onclick="displayToggle('datamg');">功能扩展</div>
			<div id="datamg">
            <div class="sidebarsubmenu"><a href="plugin.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin.gif" align="absbottom" border="0"> 插件</a></div>
			</div>
			<div id="sidebarBottom"></div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
</td>
<td id=container valign=top align=left>
<?php doAction('adm_main_top'); ?>