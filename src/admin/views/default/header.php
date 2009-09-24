<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<link href="./views/<?php echo ADMIN_TPL; ?>/css-main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../lib/js/jquery/jquery-1.2.6.js"></script>
<script type="text/javascript" src="../lib/js/jquery/plugin-cookie.js"></script>
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
<?php doAction('adm_head');?>
<title><?php echo $blogname; ?> - 管理中心</title>
</head>
<body>
<div class="center">
<table id=header cellspacing=0 cellpadding=0 width="988" border=0>
  <tbody>
  <tr>
    <td width="9" id="headerleft"></td>
    <td width="125"  class="logo" align="left"><a href="./" title="返回管理首页">emlog</a></td>
    <td class="vesion" width="20"><?php echo EMLOG_VERSION; ?></td>
    <td  class="home" align="left"><a href="../" target="_blank" title="在新窗口浏览我的blog"><?php echo $blogname; ?></a></td>
    <td align=right nowrap class="headtext">
	你好：<a href="blogger.php" title="点击修改个人资料"><?php if($userData['nickname']):echo $userData['nickname'];else:echo $userData['username'];endif;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php if (ROLE == 'admin'):?>
    <a href="template.php" ><img src="./views/<?php echo ADMIN_TPL; ?>/images/skin.gif" align="absmiddle" border="0"> 换模板</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="configure.php">博客设置</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php endif;?>
	<a href="./">管理首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="./?action=logout">退出</a>&nbsp;&nbsp;&nbsp;&nbsp;	</td>
    <td width="9" id="headerright" ></td>
	</tbody>
</table>
<table cellspacing=0 cellpadding=0 width="100%" border=0>
<tbody >
  <tr>
    <td valign=top align=left width="114">
    <div id=sidebartop></div>
	<table cellspacing=0 cellpadding=0 width="100%" border=0>
        <tbody>
        <tr>
          <td valign=top align=left width="114">
            <div id=sidebar>
            <div class="sidebarmenu" onclick="displayToggle('log_mg', 1);">日志管理</div>
			<div id="log_mg">
            <div class="sidebarsubmenu" id="menu_wt"><a href="write_log.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/addblog.gif" align="absbottom" border="0">写日志</a></div>
			<div class="sidebarsubmenu" id="menu_draft"><a href="admin_log.php?pid=draft">草稿<span id="dfnum">
			<?php 
			if (ROLE == 'admin'){
				echo $sta_cache['draftnum'] == 0 ? '' : '('.$sta_cache['draftnum'].')'; 
			}else{
				echo $user_cache[UID]['draftnum'] == 0 ? '' : '('.$user_cache[UID]['draftnum'].')';
			}
			?>
			</span></a></div>
			<div class="sidebarsubmenu" id="menu_log"><a href="admin_log.php">日志</a></div>
			<?php if (ROLE == 'admin'):?>
            <div class="sidebarsubmenu" id="menu_tag"><a href="tag.php">标签</a></div>
            <div class="sidebarsubmenu" id="menu_sort"><a href="sort.php">分类</a></div>
            <?php endif;?>
            <div class="sidebarsubmenu" id="menu_cm"><a href="comment.php">评论</a> </div>
            <div class="coment_number"><a href="#">99+</a></div>
            <div class="sidebarsubmenu" id="menu_tb"><a href="trackback.php">引用</a></div>
			</div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
	<?php if (ROLE == 'admin'):?>
      <table cellspacing=0 cellpadding=0 width="100%" border=0 >
        <tbody>
        <tr>
          <td valign=top align=left width=114>
            <div id=sidebar>
            <div class="sidebarmenu" onclick="displayToggle('blog_mg', 1);">博客管理</div>
			<div id="blog_mg">
            <div class="sidebarsubmenu" id="menu_widget"><a href="widgets.php" >Widgets</a></div>
			<div class="sidebarsubmenu" id="menu_page"><a href="page.php" >页面</a></div>
			<div class="sidebarsubmenu" id="menu_link"><a href="link.php">链接</a></div>
			<div class="sidebarsubmenu" id="menu_user"><a href="user.php" >作者</a></div>
			<div class="sidebarsubmenu" id="menu_data"><a href="data.php">数据</a></div>
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
            <div class="sidebarmenu" onclick="displayToggle('extend_mg', 1);">功能扩展</div>
			<div id="extend_mg">
            <div class="sidebarsubmenu" id="menu_plug"><a href="plugin.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin.gif" align="absbottom" border="0"> 插件</a></div>
            <?php doAction('adm_sidebar_ext'); ?>
			</div>
			</div>
       	    </td>
		  </tr>
		</tbody>
	</table>
	<?php endif;?>
	<div id="sidebarBottom"></div>
</td>
<td id=container valign=top align=left>
<?php doAction('adm_main_top'); ?>
<script type="text/javascript">
$("#blog_mg").css('display', $.cookie('em_blog_mg') ? $.cookie('em_blog_mg') : '');
$("#log_mg").css('display', $.cookie('em_log_mg') ? $.cookie('em_log_mg') : '');
$("#extend_mg").css('display', $.cookie('em_extend_mg') ? $.cookie('em_extend_mg') : '');
</script>