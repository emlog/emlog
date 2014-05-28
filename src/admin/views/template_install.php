<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<a class="navi1" href="./template.php"><? echo $lang['template_current']; ?></a>
<a class="navi2" href="./template.php?action=install"><? echo $lang['template_install']; ?></a>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['template_zip_only']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['template_not_writable']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['template_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['template_select_zip']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['template_non_standard']; ?></span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 20px;">
<div class="des">
<? echo $lang['template_install_manually']; ?>
</div>
</div>
<?php endif; ?>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<input name="tplzip" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" /> <? echo $lang['template_upload_zip']; ?>
	</li>
</div>
</form>
<div style="margin:10px 20px;"><? echo $lang['templates_more']; ?>: <a href="store.php"><? echo $lang['app_center']; ?>&raquo;</a></div>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>