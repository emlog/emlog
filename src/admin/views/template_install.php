<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<!--vot--><a class="navi1" href="./template.php"><?=lang('template_current')?></a>
<!--vot--><a class="navi2" href="./template.php?action=install"><?=lang('template_mount')?></a>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('template_zip_support')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('template_upload_failed_nonwritable')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('template_no_zip_install_manually')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('template_select_zip')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('template_non_standard')?></span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 20px;">
<div class="des">
<!--vot--><?=lang('template_install_manual')?>:<br />
<!--vot--><?=lang('template_install_prompt1')?> <br />
<!--vot--><?=lang('template_install_prompt2')?> <br />
</div>
</div>
<?php endif; ?>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<input name="tplzip" type="file" />
<!--vot--><input type="submit" value="<?=lang('upload_install')?>" class="button" /> <?=lang('template_upload_prompt')?>
	</li>
</div>
</form>
<!--vot--><div style="margin:10px 20px;"><?=lang('template_get_more')?>: <a href="store.php"><?=lang('app_center')?>&raquo;</a></div>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>