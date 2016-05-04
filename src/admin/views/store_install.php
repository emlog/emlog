<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle">
<b><?=lang('install')?> <?= $source_typename;?></b>
<div class=line></div>
<!--vot--><div id="addon_ins"><span class="ajaxload"><?= $source_typename;?><?=lang('package_downloading')?></span></div>
</div>
<script>
$("#menu_store").addClass('active');
$(document).ready(function(){
    $.get('./store.php', {action:'addon', source:"<?= $source;?>", type:"<?= $source_type;?>" },
      function(data){
        if (data.match("succ")) {
/*vot*/        $("#addon_ins").html('<span id="addonsucc"><?= $source_typename;?><?=lang('plugin_install_ok')?> <?= $source_typeurl;?></span>');
        } else if(data.match("error_down")){
/*vot*/        $("#addon_ins").html('<span id="addonerror"><?= $source_typename;?><?=lang('plugin_download_failed')?> <a href="store.php"><?=lang('return_app_center')?></a></span>');
        } else if(data.match("error_zip")){
/*vot*/        $("#addon_ins").html('<span id="addonerror"><?= $source_typename;?><?=lang('install_failed_zip_nonsupport')?> <a href="store.php"><?=lang('return_app_center')?></a></span>');
        } else if(data.match("error_dir")){
/*vot*/        $("#addon_ins").html('<span id="addonerror"><?= $source_typename;?><?=lang('install_failed_folder_nonwritable')?> <a href="store.php"><?=lang('return_app_center')?></a></span>');
        }else{
/*vot*/        $("#addon_ins").html('<span id="addonerror"><?= $source_typename;?><?=lang('install_failed')?> <a href="store.php"><?=lang('return_app_center')?></a></span>');
        }
      });
})
</script>
