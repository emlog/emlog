<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_edit'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('personal_data_modified_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('avatar_deleted_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('nickname_too_long')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('email_format_invalid')?></div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_not_equal')?></div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('username_exists')?></div><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('nickname_exists')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
	<?php if (ROLE == ROLE_ADMIN): ?>
        <ul class="nav nav-pills">
<!--vot--><li class="nav-item"><a class="nav-link" href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link active" href="./blogger.php"><?=lang('personal_settings')?></a></li>
        </ul>
	<?php else: ?>
        <ul class="nav nav-tabs" role="tablist">
<!--vot-->  <li role="presentation" class="active"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
        </ul>
	<?php endif; ?>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <div class="row m-5">
            <div class="col-md-4">
                <label for="upload_image">
                    <img src="<?php echo $icon; ?>" width="180" id="avatar_image" class="rounded-circle"/>
                    <input type="file" name="image" class="image" id="upload_image" style="display:none"/>
                </label>
            </div>
        </div>

        <form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
<!--vot-->          <label><?=lang('nickname')?></label>
                    <input class="form-control" value="<?php echo $nickname; ?>" name="name">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('email')?></label>
                    <input name="email" class="form-control" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('personal_description')?></label>
                    <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('login_name')?></label>
                    <input class="form-control" value="<?php echo $username; ?>" name="username">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('new_password_info')?></label>
                    <input type="password" class="form-control" value="" name="newpass">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('new_password_repeat')?></label>
                    <input type="password" class="form-control" value="" name="repeatpass">
                </div>
                <div class="form-group">
					<?php doAction('blogger_ext'); ?>
                </div>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->      <input type="submit" value="<?=lang('save_data')?>" class="btn btn-sm btn-success"/>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                        <div class="col-md-8">
                            <img src="" id="sample_image"/>
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
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
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 180,
                height: 180
            });
            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: './blogger.php?action=update_avatar',
                        method: 'POST',
                        data: {image: base64data},
                        success: function (data) {
                            $modal.modal('hide');
                            if (data != "error") {
                                $('#avatar_image').attr('src', data);
                            }
                        }
                    });
                };
            });
        });
    });
</script>
