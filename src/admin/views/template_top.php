<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>自定义顶部图片</b>
<?php if(isset($_GET['activated'])):?><span class="actived">顶部图片更换成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">裁剪图片失败</span><?php endif;?>
</div>
<div class=line></div>
<?php if(!file_exists('../' . $topimg)): ?>
<div class="error_msg">当前使用的顶部图片已被删除或损坏，请选择其它图片。</div>
<?php else:?>
<div id="topimg_preview"><img src="<?php echo '../'.$topimg; ?>" width="758" height="105" /></div>
<?php endif;?>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
<div class="topimg_line">可选图片</div>
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
	<a href="./template.php?action=update_top&top=<?php echo $imgpath_url; ?>" title="点击使用该图片" >
	<img src="../<?php echo $mini_imgpath; ?>" width="230px" height="48px" class="topTH" />
	</a>
	<?php if (!is_array($val)):?>
	<li class="admin_style_info" >
	<a href="./template.php?action=del_top&top=<?php echo $imgpath_url; ?>">删除</a>
	</li>
	<?php endif;?>
	</div>
	<?php endforeach; ?>
</div>
</form>
<div class="topimg_line">自定义图片</div>
<form action="./template.php?action=upload_top" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="topimg" type="file" />
	<input type="submit" value="上传" class="submit" /> (上传一张你喜欢的顶部图片，支持JPG、PNG格式图片)
	</li>
</div>
</form>