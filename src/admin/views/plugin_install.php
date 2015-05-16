<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle"><b>?=lang('plugin_install')?></b><div id="msg"></div>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('plugin_zipped_only')?></span><?php endif;?>
    <?php if(isset($_GET['error_b'])):?><span class="alert alert-danger"><?=lang('plugin_upload_failed_nonwritable')?></span><?php endif;?>
    <?php if(isset($_GET['error_c'])):?><span class="alert alert-danger"><?=lang('plugin_zip_nonsupport')?></span><?php endif;?>
    <?php if(isset($_GET['error_d'])):?><span class="alert alert-danger"><?=lang('plugin_zip_select')?></span><?php endif;?>
    <?php if(isset($_GET['error_e'])):?><span class="alert alert-danger"><?=lang('plugin_install_failed_wrong_format')?></span><?php endif;?>
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
setTimeout(hideActived, 2600);
$("#menu_category_sys").addClass('active');
$("#menu_sys").addClass('in');
$("#menu_plug").addClass('active');
</script>
