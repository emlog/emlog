<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>

<?php foreach ($medias as $key => $value):
	$media_path = $value['filepath'];
	$media_url = rmUrlParams(getFileUrl($media_path));
	$media_name = $value['filename'];
	if (isImage($value['mimetype'])) {
		$media_icon = getFileUrl($value['filepath_thum']);
	} elseif (isZip($value['filename'])) {
		$media_icon = "./views/images/zip.jpg";
	} elseif (isVideo($value['filename'])) {
		$media_icon = "./views/images/video.png";
	} else {
		$media_icon = "./views/images/fnone.png";
	}
	?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <a href="<?= $media_url ?>" target="_blank"><img class="card-img-top" src="<?= $media_icon ?>"/></a>
            <div class="card-body">
                <p class="card-text text-muted small">
					<?= $media_name ?><br>
                    上传时间：<?= $value['addtime'] ?><br>
                    文件大小：<?= $value['attsize'] ?>，
                </p>
                <p class="card-text d-flex justify-content-between">
					<?php if (isImage($value['mimetype'])): ?>
                        <a href="javascript:insert_media_img('<?= $media_url ?>', '<?= $media_icon ?>')" class="btn" title="插入文章"><i class="icofont-plus"></i></a>
                        <a href="javascript:insert_cover('<?= $media_path ?>')" class="btn" title="设为封面"><i class="icofont-image"></i></a>
					<?php elseif (isVideo($value['filepath'])): ?>
                        <a href="javascript:insert_media_video('<?= $media_url ?>')" class="btn" title="插入文章"><i class="icofont-plus"></i></a>
					<?php else: ?>
                        <a href="javascript:insert_media('<?= $media_url ?>', '<?= $media_name ?>')" class="btn" title="插入文章"><i class="icofont-plus"></i></a>
					<?php endif ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach ?>

