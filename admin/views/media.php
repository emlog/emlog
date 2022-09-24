<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_mov'])): ?>
    <div class="alert alert-success">移动成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">分类添加成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">分类名称不能为空</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">多媒体资源</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> 上传图片/文件</a>
</div>
<div class="row mb-3 ml-1">
    <a href="media.php" class="btn btn-primary btn-sm mr-2">全部资源</a>
	<?php foreach ($sorts as $key => $val): ?>
        <div class="btn-group mr-2">
            <a href="media.php?sid=<?= $val['id'] ?>" type="button" class="btn btn-primary btn-sm"><?= $val['sortname'] ?></a>
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false"></button>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#editModal" data-id="<?= $val['id'] ?>" data-sortname="<?= $val['sortname'] ?>">编辑</a>
                <a class="dropdown-item text-danger" href="javascript: em_confirm(<?= $val['id'] ?>, 'media_sort', '<?= LoginAuth::genToken() ?>');">删除</a>
            </div>
        </div>
	<?php endforeach ?>
    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mediaSortModal"><i class="icofont-plus"></i>添加分类</a>
</div>
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
                            时间：<?= $value['addtime'] ?><br>
                            创建人：<?= $author ?><br>
                            文件大小：<?= $value['attsize'] ?>，
							<?php if ($value['width'] && $value['height']): ?>
                                图片尺寸：<?= $value['width'] ?>x<?= $value['height'] ?><br>
                                原图地址：<span class="text-gray-400"><?= $media_url ?></span>
							<?php endif ?>
                        </p>
                        <p class="card-text d-flex justify-content-between">
                            <a href="javascript: em_confirm(<?= $value['aid'] ?>, 'media', '<?= LoginAuth::genToken() ?>');" class="text-danger small">删除</a>
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
            <a href="javascript:mediaact('del');" class="btn btn-sm btn-danger">删除所选资源</a>
            <select name="sort" id="sort" onChange="changeSort(this);" class="form-control m-1">
                <option value="" selected="selected">移动到</option>
				<?php foreach ($sorts as $key => $value): ?>
                    <option value="<?= $value['id'] ?>"><?= $value['sortname'] ?></option>
				<?php endforeach; ?>
                <option value="0">未分类</option>
            </select>
        </div>
        <div class="col-auto my-1">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="checkAllCard">
                <label class="custom-control-label" for="checkAllCard">全选</label>
            </div>
        </div>
    </div>
</form>
<div class="page my-5"><?= $pageurl ?> （有 <?= $count ?> 个资源）</div>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">上传图片/文件</h5>
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

<div class="modal fade bd-example-modal-lg" id="mediaSortModal" tabindex="-1" role="dialog" aria-labelledby="mediaSortModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaSortModalLabel">添加资源分类</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="media.php?action=add_media_sort" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alias">分类名称</label>
                        <input class="form-control" id="sortname" maxlength="255" name="sortname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改资源分类</h5>
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
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
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
        if (getChecked('aids') == false) {
            alert('请选择要删除的资源');
            return;
        }
        if (act == 'del' && !confirm('确定要删除所选资源吗？')) {
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

    // 更改分类
    function changeSort(obj) {
        if (getChecked('aids') == false) {
            alert('请选择要移动的资源');
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
        $('.highslide').removeAttr('onclick')  // 如果是移动端，则不使用 highslide 功能
    }
</script>
