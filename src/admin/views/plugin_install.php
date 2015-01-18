<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<!--vot--><div class=containertitle><b><?=lang('plugin_install')?></b><div id="msg"></div>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('plugin_zipped_only')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('plugin_upload_failed_nonwritable')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('plugin_zip_nonsupport')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('plugin_zip_select')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('plugin_install_failed_wrong_format')?></span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
<!--vot--><?=lang('plugin_install_manually')?>:<br />
<!--vot--><?=lang('install_promt_1')?><br />
<!--vot--><?=lang('install_prompt2')?><br />
</div>
</div>
<?php endif; ?>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
    <li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input name="pluzip" type="file" />
<!--vot--><input type="submit" value="<?=lang('upload_install')?>" class="button" /> <?=lang('upload_install_info')?>
    </li>
</div>
</form>
<!--vot--><div style="margin:10px 20px;"><?=lang('plugin_get_more')?>: <a href="store.php"><?=lang('app_center')?></a></div>
<script>
$("#menu_plug").addClass('sidebarsubmenu1');
</script>