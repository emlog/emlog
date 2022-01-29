<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">资料修改成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">头像删除成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">昵称不能太长</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">电子邮件格式错误</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">密码长度不得小于6位</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">两次输入的密码不一致</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">该登录名已存在</div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">该昵称已存在</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
	<?php if (User::isAdmin()): ?>
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO优化</a></li>
            <li class="nav-item"><a class="nav-link active" href="./blogger.php">个人信息</a></li>
        </ul>
	<?php else: ?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="./blogger.php">个人设置</a></li>
        </ul>
	<?php endif ?>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <div class="row m-5">
            <div class="col-md-4">
                <label for="upload_image">
                    <img src="<?= $icon ?>" width="180" id="avatar_image" class="rounded-circle"/>
                    <input type="file" name="image" class="image" id="upload_image" style="display:none"/>
                </label>
            </div>
        </div>

        <form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
                    <label>昵称</label>
                    <input class="form-control" value="<?= $nickname ?>" name="name">
                </div>
                <div class="form-group">
                    <label>邮箱</label>
                    <input name="email" class="form-control" value="<?= $email ?>">
                </div>
                <div class="form-group">
                    <label>个人描述</label>
                    <textarea name="description" class="form-control"><?= $description ?></textarea>
                </div>
                <div class="form-group">
                    <label>登录用户名</label>
                    <input class="form-control" value="<?= $username ?>" name="username">
                </div>
                <div class="form-group">
                    <label>新密码（不小于6位，不修改请留空）</label>
                    <input type="password" name="hidden-auto-filling" style="width: 0;border: 0;opacity: 0">
                    <input type="password" class="form-control" value="" name="newpass">
                </div>
                <div class="form-group">
                    <label>再输入一次新密码</label>
                    <input type="password" class="form-control" value="" name="repeatpass">
                </div>
                <div class="form-group">
					<?php doAction('blogger_ext') ?>
                </div>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存资料" class="btn btn-sm btn-success"/>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">裁剪并上传</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-11">
                            <img src="" id="sample_image"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bt btn-sm btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);

    $(document).ready(function () {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function (event) {
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160
            });

            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('image', blob, 'avatar.jpg');
                $.ajax('./blogger.php?action=update_avatar', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $modal.modal('hide');
                        if (data != "error") {
                            $('#avatar_image').attr('src', data);
                        }
                    }
                });
            });

        });
    });
</script>
