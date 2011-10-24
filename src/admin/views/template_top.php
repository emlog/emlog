<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['top_image_customize']; ?></b>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['top_image_replaced_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['top_image_deleted_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['image_crop_failed']; ?></span><?php endif;?>
</div>
<div class=line></div>
<?php if(!file_exists('../' . $topimg)): ?>
<div class="error_msg"><? echo $lang['top_image_damaged']; ?></div>
<?php else:?>
<div id="topimg_preview"><img src="<?php echo '../'.$topimg; ?>" width="758" height="105" /></div>
<?php endif;?>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
<div class="topimg_line"><? echo $lang['image_optional']; ?></div>
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
	<a href="./template.php?action=update_top&top=<?php echo $imgpath_url; ?>" title="<? echo $lang['use_this_image']; ?>" >
	<img src="../<?php echo $mini_imgpath; ?>" width="230px" height="48px" class="topTH" />
	</a>
	<?php if (!is_array($val)):?>
	<li class="admin_style_info" >
	<a href="./template.php?action=del_top&top=<?php echo $imgpath_url; ?>"><? echo $lang['remove']; ?></a>
	</li>
	<?php endif;?>
	</div>
	<?php endforeach; ?>
</div>
</form>
<div class="topimg_line"><? echo $lang['custom_image']; ?></div>
<form action="./template.php?action=upload_top" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="topimg" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" /> <? echo $lang['top_image_prompt']; ?>
	</li>
</div>
</form>