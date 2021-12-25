<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>

<?php foreach ($medias as $key => $value):
	$media_path = $value['filepath'];
	$media_url =rmUrlParams(getFileUrl($media_path));
	$media_name = $value['filename'];
	if (isImage($value['mimetype'])) {
		$media_icon = getFileUrl($value['filepath_thum']);
	} else {
		$media_icon = "./views/images/fnone.png";
	}
	?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <a href="<?php echo $media_url; ?>" target="_blank"><img class="card-img-top" src="<?php echo $media_icon; ?>"/></a>
            <div class="card-body">
                <p class="card-text text-muted small">
					<?php echo $media_name; ?><br>
<!--vot-->      <?=lang('upload_time')?>: <?php echo $value['addtime']; ?><br>
<!--vot-->      <?=lang('file_size')?>: <?php echo $value['attsize']; ?>,
                </p>
                <p class="card-text d-flex justify-content-between">
					<?php if (isImage($value['mimetype'])): ?>
<!--vot-->              <a href="javascript:insert_media_img('<?php echo $media_url; ?>', '<?php echo $media_icon; ?>')" title="<?=lang('insert_into')?>"><i class="icofont-plus"></i></a>
<!--vot-->              <a href="javascript:insert_conver('<?php echo $media_path; ?>')" title="<?=lang('set_cover')?>"><i class="icofont-image"></i></a>
					<?php elseif (isVideo($value['filepath'])): ?>
                        <a href="javascript:insert_media_video('<?php echo $media_url; ?>')"><i class="icofont-plus"></i></a>
					<?php else: ?>
                        <a href="javascript:insert_media('<?php echo $media_url; ?>', '<?php echo $media_name; ?>')"><i class="icofont-plus"></i></a>
					<?php endif; ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

