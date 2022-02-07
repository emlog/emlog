<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">多媒体资源</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> 上传图片/文件</a>
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
        <div class="col-auto my-1">
            <a href="javascript:mediaact('del');" class="btn btn-sm btn-danger">删除所选资源</a>
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
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $("#menu_media").addClass('active');
    setTimeout(hideActived, 3600);
    $('#exampleModal').on('hidden.bs.modal', function (e) {
        window.location.reload();
    })
    Dropzone.options.myAwesomeDropzone = {
        maxFilesize: 2048,// 单位M
        paramName: "file",
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
</script>
<link rel="stylesheet" type="text/css" href="./views/highslide/highslide.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"/>
<script src="./views/highslide/highslide.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    if(window.outerWidth > 767){
        hs.graphicsDir = './views/highslide/graphics/';
        hs.wrapperClassName = 'rounded-white';
    }else{
        $('.highslide').removeAttr ('onclick')  // 如果是移动端，则不使用 highslide 功能
    }
</script>
