<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('template_top_image')?></b>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="actived"><?=lang('image_replace_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('image_crop_error')?></span><?php endif;?>
</div>
<div class=line></div>
<?php if(!$topimg || !file_exists('../' . $topimg)): ?>
<!--vot--><div class="warning"><?=lang('top_image_unavailable')?></div>
<?php else:?>
<div id="topimg_preview"><img src="<?php echo '../'.$topimg; ?>" width="758" height="105" /></div>
<?php endif;?>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
<!--vot--><div class="topimg_line"><?=lang('images_optional')?></div>
<div id="topimg_default">
    <?php 
    foreach ($topimgs as $val): 
    $imgpath = $val;
    if(is_array($val)) {
        $imgpath = $val['path'];
    }
    $imgpath_url = urlencode($imgpath);
    $mini_imgpath = str_replace('.jpg', '_mini.jpg', $imgpath);
    if (!file_exists('../' . $mini_imgpath)) {
        continue;
    }
    ?>
    <div>
<!--vot--><a href="./template.php?action=update_top&top=<?php echo $imgpath_url; ?>" title="<?=lang('image_click_to_use')?>" >
    <img src="../<?php echo $mini_imgpath; ?>" width="230px" height="48px" class="topTH" />
    </a>
    <?php if (!is_array($val)):?>
    <li class="admin_style_info" >
<!--vot--><a href="./template.php?action=del_top&top=<?php echo $imgpath_url; ?>" class="care"><?=lang('delete')?></a>
    </li>
    <?php endif;?>
    </div>
    <?php endforeach; ?>

    <div>
<!--vot--><a href="./template.php?action=update_top" title="<?=lang('top_image_not_use')?>" >
    <img src="../content/templates/default/images/null.jpg" width="230px" height="48px" class="topTH" />
    </a>
<!--vot--><li class="admin_style_info" ><?=lang('top_image_not_use')?></li>
    </div>
</div>
</form>
<!--vot--><div class="topimg_line"><?=lang('top_image_custom')?></div>
<form action="./template.php?action=upload_top" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
    <li></li>
    <li>
    <input name="topimg" type="file" />
<!--vot--><input type="submit" value="<?=lang('upload')?>" class="button" /> <?=lang('top_image_upload_prompt')?>
    </li>
</div>
</form>
<script>
$("#menu_tpl").addClass('sidebarsubmenu1');
setTimeout(hideActived,2600);
</script>