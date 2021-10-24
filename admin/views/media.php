<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('resource_manage')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?=lang('upload_files')?></a>
</div>

<form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
    <div class="card-columns">
		<?php foreach ($medias as $key => $value):
			$media_url = getFileUrl($value['filepath']);
			$media_name = $value['filename'];
			if (isImage($value['filepath'])) {
				$media_icon = getFileUrl($value['filepath_thum']);
			} else {
				$media_icon = "./views/images/fnone.png";
			}
			?>
            <div class="card" style="min-height: 280px;">
                <a href="<?php echo $media_url; ?>" target="_blank""><img class="card-img-top" src="<?php echo $media_icon; ?>"/></a>
                <div class="card-body">
                    <p class="card-text text-muted small">
						<?php echo $media_name; ?><br>
<!--vot-->              <?=lang('create_time')?>: <?php echo $value['addtime']; ?><br>
<!--vot-->              <?=lang('file_size')?>: <?php echo $value['attsize']; ?>,
						<?php if ($value['width'] && $value['height']): ?>
<!--vot-->              <?=lang('img_size')?>: <?php echo $value['width'] ?>x<?php echo $value['height'] ?>
						<?php endif; ?>
                    </p>
                    <p class="card-text d-flex justify-content-between">
<!--vot-->              <a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'media', '<?php echo LoginAuth::genToken(); ?>');" class="text-danger small"><?=lang('delete')?></a>
                        <input type="checkbox" name="aids[]" value="<?php echo $value['aid']; ?>" class="aids"/>
                    </p>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
    <div class="form-row align-items-center">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
        <input name="operate" id="operate" value="" type="hidden"/>
        <div class="col-auto my-1">
<!--vot-->  <a href="javascript:mediaact('del');" class="btn btn-sm btn-danger"><?= lang('resource_del_selected') ?></a>
        </div>
        <div class="col-auto my-1">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="checkAllCard">
<!--vot-->      <label class="custom-control-label" for="checkAllCard"><?=lang('select_all')?></label>
            </div>
        </div>
    </div>
</form>
<!--vot--><div class="page my-5"><?php echo $pageurl; ?> (<?=lang('have')?> <?php echo $count; ?> <?=lang('_resources')?>)</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('upload_files')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./media.php?action=upload" class="dropzone" id="my-awesome-dropzone"></form>
            </div>

        </div>
    </div>
</div>
<script src="./views/js/dropzone.min.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<script>
    $("#menu_media").addClass('active');
    setTimeout(hideActived, 3600);
    $('#exampleModal').on('hidden.bs.modal', function (e) {
        window.location.reload();
    })
    Dropzone.options.myAwesomeDropzone = {
        maxFilesize: 2048,// Unit: M
        paramName: "file",
        init: function () {
            this.on("error", function (file, response) {
                // alert(response);
            });
        }
    };

    function mediaact(act) {
        if (getChecked('aids') == false) {
/*vot*/     alert('<?= lang('resource_select') ?>');
            return;
        }
/*vot*/ if (act == 'del' && !confirm('<?= lang('resource_del_sure') ?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_media").submit();
    }
</script>
