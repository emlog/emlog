<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
          <div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif ?>
<?php if (isset($_GET['active_mov'])): ?>
          <div class="alert alert-success"><?=lang('moved_ok')?></div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
          <div class="alert alert-success"><?=lang('modified_ok')?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
          <div class="alert alert-success"><?=lang('media_category_add_ok')?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
          <div class="alert alert-danger"><?=lang('category_name_empty')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?=lang('resource_manage')?></h1>
          <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target=" #exampleModal"><i class="icofont-plus"></i> <?=lang('upload_files')?></a>
</div>
<?php if (User::isAdmin()): ?>
    <div class="row mb-4 ml-1">
          <a href="media.php" class="btn btn-sm btn-primary mr-2 my-1"><?=lang('modified_ok')?></a>
		<?php foreach ($sorts as $key => $val):
			$cur_tab = $val['id'] == $sid ? "btn-success" : "btn-primary";
			?>
            <div class="btn-group mr-2 my-1">
                <a href="media.php?sid=<?= $val['id'] ?>" class="btn btn-sm <?= $cur_tab ?>"><?= $val['sortname'] ?></a>
                <button type="button" class="btn <?= $cur_tab ?> btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false"></button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#editModal" data-id="<?= $val['id'] ?>" data-sortname="<?= $val['sortname'] ?>"><?=lang('edit')?></a>
                    <a class="dropdown-item text-danger" href="javascript: em_confirm(<?= $val['id'] ?>, 'media_sort', '<?= LoginAuth::genToken() ?>');"><?=lang('delete')?></a>
                </div>
            </div>
		<?php endforeach ?>
        <a href="#" class="btn btn-success btn-sm my-1" data-toggle="modal" data-target="#mediaSortModal"><i class="icofont-plus"></i></a>
    </div>
<?php endif; ?>
<form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
    <div class="row">
		<?php foreach ($medias as $key => $value):
			$media_url = rmUrlParams(getFileUrl($value['filepath']));
			$sort_name = $value['sortname'];
			$media_name = $value['filename'];
			$author = $user_cache[$value['author']]['name'];
			if (isImage($value['mimetype'])) {
				$media_icon = getFileUrl($value['filepath_thum']);
				$imgviewer = 'class="highslide" onclick="return hs.expand(this)"';
			} elseif (isZip($value['filename'])) {
				$media_icon = "./views/images/zip.jpg";
				$imgviewer = '';
			} elseif (isVideo($value['filename'])) {
				$media_icon = "./views/images/video.png";
				$imgviewer = '';
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
							<?= $media_name ?> <span class="badge badge-primary"><?= $sort_name ?></span><br>
                            <?=lang('create_time')?>: <?= $value['addtime'] ?><br>
                            <?=lang('founder')?>: <?= $author ?><br>
                            <?=lang('file_size')?>: <?= $value['attsize'] ?>,
							<?php if ($value['width'] && $value['height']): ?>
                        <?=lang('img_size')?>: <?= $value['width'] ?>x<?= $value['height'] ?>
                                <?=lang('image_address_original')?>: <span class="text-gray-400"><?= $media_url ?></span>
							<?php endif ?>
                        </p>
                        <p class="card-text d-flex justify-content-between">
                        <a href="javascript: em_confirm(<?= $value['aid'] ?>, 'media', '<?= LoginAuth::genToken() ?>');" class="text-danger small"><?=lang('delete')?></a>
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
        <div class="col-auto my-1 form-inline">
            <a href="javascript:mediaact('del');" class="btn btn-sm btn-danger"><?= lang('resource_del_selected') ?></a>
			<?php if (User::isAdmin()): ?>
                <select name="sort" id="sort" onChange="changeSort(this);" class="form-control m-1">
                    <option value="" selected="selected"><?=lang('move_to')?></option>
					<?php foreach ($sorts as $key => $value): ?>
                        <option value="<?= $value['id'] ?>"><?= $value['sortname'] ?></option>
					<?php endforeach; ?>
                    <option value="0"><?=lang('uncategorized')?></option>
                </select>
			<?php endif; ?>
        </div>
        <div class="col-auto my-1">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="checkAllCard">
                <label class="custom-control-label" for="checkAllCard"><?=lang('select_all')?></label>
            </div>
        </div>
    </div>
</form>
          <div class="page my-5"><?= $page ?> (<?=lang('have')?> <?= $count ?> <?=lang('_resources')?>)</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=lang('upload_files')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="./media.php?action=upload<?= '&sid=' . $sid ?>" class="dropzone" id="my-awesome-dropzone"></form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="mediaSortModal" tabindex="-1" role="dialog" aria-labelledby="mediaSortModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaSortModalLabel"><?=lang('media_category_add')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="media.php?action=add_media_sort" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alias"><?=lang('category_name')?></label>
                        <input class="form-control" id="sortname" maxlength="255" name="sortname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?=lang('save')?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=lang('change_media_category')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="media.php?action=update_media_sort">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sortname" name="sortname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="id" name="id"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?=lang('save')?></button>
                </div>
            </form>
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
        maxFilesize: 2048,// MB
        paramName: "file",
        timeout: 3600000,// milliseconds
        init: function () {
            this.on("error", function (file, response) {
                // alert(response);
            });
        }
    };

    function mediaact(act) {
        if (getChecked('aids') === false) {
    alert('<?= lang('resource_select') ?>');
            return;
        }
if (act == 'del' && !confirm('<?= lang('resource_del_sure') ?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_media").submit();
    }

    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var sortname = button.data('sortname')
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body input').val(sortname)
        modal.find('.modal-footer input').val(id)
    })

    // Change category
    function changeSort(obj) {
        if (getChecked('aids') === false) {
    alert(lang('media_select'));
            return;
        }
        if ($('#sort').val() == '') return;
        $("#operate").val('move');
        $("#form_media").submit();
    }
</script>
<link rel="stylesheet" type="text/css" href="./views/highslide/highslide.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"/>
<script src="./views/highslide/highslide.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    if (window.outerWidth > 767) {
        hs.graphicsDir = './views/highslide/graphics/';
        hs.wrapperClassName = 'rounded-white';
    } else {
        $('.highslide').removeAttr('onclick')  // If it is a mobile terminal, do not use the highslide function
    }
</script>
