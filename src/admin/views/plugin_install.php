<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>安装插件</h1>
    <div class="containertitle"><b>导航管理</b>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">只支持zip压缩格式的插件包</span><?php endif;?>
    <?php if(isset($_GET['error_b'])):?><span class="alert alert-danger">上传失败，插件目录(content/plugins)不可写</span><?php endif;?>
    <?php if(isset($_GET['error_c'])):?><span class="alert alert-danger">空间不支持zip模块，请按照提示手动安装插件</span><?php endif;?>
    <?php if(isset($_GET['error_d'])):?><span class="alert alert-danger">请选择一个zip插件安装包</span><?php endif;?>
    <?php if(isset($_GET['error_e'])):?><span class="alert alert-danger">安装失败，插件安装包不符合标准</span><?php endif;?>
    </div>
</section>
<section class="content">
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
</section>
<script>
setTimeout(hideActived, 2600);
$("#menu_plug").addClass('active').parent().parent().addClass('active');
</script>
