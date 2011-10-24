<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['plugin_management']; ?></b><div id="msg"></div>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['plugin_zip_only']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['plugin_not_writable']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['plugin_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['plugin_use_zip']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['plugin_non_standard']; ?></span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
<? echo $lang['plugin_install_manually']; ?>
</div>
</div>
<?php endif; ?>
<div style="margin:20px 10px;">
<div class="des"><? echo $lang['plugin_upload_zip']; ?><a href="http://www.emlog.net/plugins/" target="_blank"><? echo $lang['plugin_get_more']; ?>&raquo;</a></div>
</div>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="pluzip" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" />
	</li>
</div>
</form>
<script>
$("#menu_plug").addClass('sidebarsubmenu1');
</script>