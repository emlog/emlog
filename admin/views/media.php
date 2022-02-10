<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('resource_manage')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?=lang('upload_files')?></a>
</div>
<form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
    <div class="row">
		<?php foreach ($medias as $key => $value):
			$media_url = rmUrlParams(getFileUrl($value['filepath']));
			$media_name = $value['filename'];
			$author = $user_cache[$value['author']]['name'];
			if (isImage($value['mimetype'])) {
				$media_icon = getFileUrl($value['filepath_thum']);
				$imgviewer = 'class="highslide" onclick="return hs.expand(this)"';
			} else {
				$media_icon = "./views/images/fnone.png";
				$imgviewer = '';
			}
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a href="<?= $media_url ?>" <?= $imgviewer ?> target="_blank"><img class="card-img-top" src="<?= $media_icon ?>"/></a>
                    <div class="card-body">
                        <p class="card-text text-muted small">
							<?= $media_name ?><br>
<!--vot-->                  <?=lang('create_time')?>: <?= $value['addtime'] ?><br>
<!--vot-->                  <?=lang(founder)?>: <?= $author ?><br>
<!--vot-->                  <?=lang('file_size')?>: <?= $value['attsize'] ?>,
							<?php if ($value['width'] && $value['height']): ?>
<!--vot-->              <?=lang('img_size')?>: <?= $value['width'] ?>x<?= $value['height'] ?>
<!--vot-->                      <?=lang('image_address_original')?>: <span class="text-gray-400"><?= $media_url ?></span>
							<?php endif ?>
                        </p>
                        <p class="card-text d-flex justify-content-between">
<!--vot-->              <a href="javascript: em_confirm(<?= $value['aid'] ?>, 'media', '<?= LoginAuth::genToken() ?>');" class="text-danger small"><?=lang('delete')?></a>
                            <input type="checkbox" name="aids[]" value="<?= $value['aid'] ?>" class="aids"/>
                        </p>
                    </div>
                </div>
            </div>
		<?php endforeach ?>
    </div>
    <div class="form-row align-items-center">
        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
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
<!--vot--><div class="page my-5"><?= $pageurl ?> (<?=lang('have')?> <?= $count ?> <?=lang('_resources')?>)</div>

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
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
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
<link rel="stylesheet" type="text/css" href="./views/highslide/highslide.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"/>
<script src="./views/highslide/highslide.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    if(window.outerWidth > 767){
        hs.graphicsDir = './views/highslide/graphics/';
        hs.wrapperClassName = 'rounded-white';
    }else{
        $('.highslide').removeAttr ('onclick')  // If it is a mobile terminal, do not use the highslide function
    }
</script>
