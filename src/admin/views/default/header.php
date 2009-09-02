<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="<?php echo EMLOG_LANGUAGE; ?>" />
<meta name="author" content="emlog" />
<meta name="robots" content="noindex, nofollow">
<link href="./views/<?php echo ADMIN_TPL; ?>/css-main.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="../lib/js/jquery/jquery-1.2.6.js"></script>
<script type="text/javascript" src="../lib/js/jquery/plugin-cookie.js"></script>
<script src="../lang/<?php echo EMLOG_LANGUAGE; ?>.js" type="text/javascript"></script>
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
<?php doAction('adm_head');?>
<title><?php echo $blogname; ?> - <? echo $lang['admin_center'];?></title>
</head>
<body>
<div class="center">
<table id=header cellspacing=0 cellpadding=0 width="988" border=0>
  <tbody>
  <tr>
    <td width="9" id="headerleft"></td>
    <td width="125"  class="logo" align="left"><a href="./" title="<? echo $lang['return_to_admin_center'];?>">emlog</a></td>
    <td class="vesion" width="20"><?php echo EMLOG_VERSION; ?></td>
    <td  class="home" align="left"><a href="../" target="_blank" title="<? echo $lang['blog_view_in_new_window'];?>"><?php echo $blogname; ?></a></td>
    <td align=right nowrap class="headtext">
	<? echo $lang['you_are'];?>: <a href="blogger.php" title="<? echo $lang['click_to_edit_personal_data'];?>"><?php if($userData['nickname']):echo $userData['nickname'];else:echo $userData['username'];endif;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php if (ROLE == 'admin'):?>
    <a href="template.php" ><img src="./views/<?php echo ADMIN_TPL; ?>/images/skin.gif" align="absmiddle" border="0"> <? echo $lang['templates'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="configure.php"><? echo $lang['settings'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php endif;?>
	<a href="./"><? echo $lang['admin_center'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a href="./?action=logout"><? echo $lang['logout'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;	</td>
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
            <div class="sidebarmenu" onclick="displayToggle('log_mg', 1);"><? echo $lang['publications'];?></div>
			<div id="log_mg">
            <div class="sidebarsubmenu" id="menu_wt"><a href="write_log.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/addblog.gif" align="absbottom" border="0"><? echo $lang['post_add'];?></a></div>
			<div class="sidebarsubmenu" id="menu_draft"><a href="admin_log.php?pid=draft"><? echo $lang['drafts'];?><span id="dfnum">
			<?php 
			if (ROLE == 'admin'){
				echo $sta_cache['draftnum'] == 0 ? '' : '('.$sta_cache['draftnum'].')'; 
			}else{
				echo $user_cache[UID]['draftnum'] == 0 ? '' : '('.$user_cache[UID]['draftnum'].')';
			}
			?>
			</span></a></div>
			<div class="sidebarsubmenu" id="menu_log"><a href="admin_log.php"><? echo $lang['posts'];?></a></div>
			<?php if (ROLE == 'admin'):?>
            <div class="sidebarsubmenu" id="menu_tag"><a href="tag.php"><? echo $lang['tags'];?></a></div>
            <div class="sidebarsubmenu" id="menu_sort"><a href="sort.php"><? echo $lang['categories'];?></a></div>
            <?php endif;?>
            <div class="sidebarsubmenu" id="menu_cm"><a href="comment.php"><? echo $lang['comments'];?></a></div>
            <div class="sidebarsubmenu" id="menu_tb"><a href="trackback.php"><? echo $lang['trackbacks'];?></a></div>
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
            <div class="sidebarmenu" onclick="displayToggle('blog_mg', 1);"><? echo $lang['management'];?></div>
			<div id="blog_mg">
            <div class="sidebarsubmenu" id="menu_widget"><a href="widgets.php" >Widgets</a></div>
			<div class="sidebarsubmenu" id="menu_page"><a href="page.php"><? echo $lang['pages'];?></a></div>
			<div class="sidebarsubmenu" id="menu_link"><a href="link.php"><? echo $lang['links'];?></a></div>
			<div class="sidebarsubmenu" id="menu_user"><a href="user.php" ><? echo $lang['users'];?></a></div>
			<div class="sidebarsubmenu" id="menu_data"><a href="data.php"><? echo $lang['backup'];?></a></div>
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
            <div class="sidebarmenu" onclick="displayToggle('extend_mg', 1);"><? echo $lang['extensions'];?></div>
			<div id="extend_mg">
            <div class="sidebarsubmenu" id="menu_plug"><a href="plugin.php"><img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin.gif" align="absbottom" border="0"> <? echo $lang['plugins'];?></a></div>
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