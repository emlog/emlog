<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (User::isAdmin()): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">设置</h1>
    </div>
<?php endif; ?>
<div class="panel-heading">
    <?php if (User::isAdmin()): ?>
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai">🤖AI</a></li>
            <li class="nav-item"><a class="nav-link active" href="./blogger.php">个人信息</a></li>
        </ul>
    <?php endif; ?>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <div class="row m-5">
            <label for="upload_image">
                <img src="<?= $icon ?>" width="120" height="120" id="avatar_image" class="rounded-circle" />
                <input type="file" name="image" class="image" id="upload_image" style="display:none" />
            </label>
        </div>
        <form action="blogger.php?action=update" method="post" name="profile_setting_form" id="profile_setting_form" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
                    <label>昵称</label>
                    <input class="form-control" value="<?= $nickname ?>" name="name" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label>用户名</label>
                    <input class="form-control" value="<?= $username ?>" name="username" id="username">
                    <small>未设置用户名时，请使用邮箱登录</small>
                </div>
                <label>邮箱</label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="" value="<?= $email ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="button" id="button-addon2" data-toggle="modal" data-target="#editEmailModal" data-email="<?= $email ?>">修改</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>个人描述</label>
                    <textarea name="description" class="form-control"><?= $description ?></textarea>
                </div>
                <div class="form-group">
                    <?php doAction('blogger_ext') ?>
                </div>
                <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="保存资料" name="submit_form" id="submit_form" class="btn btn-sm btn-success" />
                <a href="#" type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#editPasswordModal">修改密码</a>
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
                            <img src="" id="sample_image" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
                <button type="button" id="use_original_image" class="btn btn-sm btn-primary">使用原图</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改密码</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="blogger.php?action=change_password" id="passwd_setting_form" method="post">
                    <div class="form-group">
                        <label>新的密码（不少于6位）</label>
                        <input type="password" class="form-control" id="new_passwd" name="new_passwd" minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label>重复新的密码</label>
                        <input type="password" class="form-control" id="new_passwd2" name="new_passwd2" minlength="6" required>
                    </div>
                    <div class="modal-footer">
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-sm btn-success">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editEmailModal" tabindex="-1" role="dialog" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改邮箱</h5>
                <span id="message" class="small ml-5"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="blogger.php?action=change_email" id="email_setting_form" method="post">
                    <div class="form-group">
                        <label>邮箱</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="邮件验证码" name="mail_code" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button" id="button-send-auth-email">发送验证码</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-sm btn-success">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#profile_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#profile_setting_form");
        });

        // 修改用户密码表单提交
        $("#passwd_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#passwd_setting_form", '密码修改成功, 请退出重新登录');
            $("#editPasswordModal").modal('hide');
        });

        // 修改邮箱表单提交
        $("#email_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#email_setting_form", '邮箱修改成功');
            $("#editEmailModal").modal('hide');
        });

        // 修改邮箱
        $('#editEmailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var email = button.data('email')
            var modal = $(this)
            modal.find('.modal-body #email').val(email)
        })
        // 邮箱验证
        $('#button-send-auth-email').click(function() {
            var email = $('#email').val();
            var $btn = $(this);
            var $message = $('#message');
            $btn.prop('disabled', true);
            var count = 60;
            var countdown = setInterval(function() {
                $btn.text('重新发送 (' + count + ')');
                if (count == 0) {
                    clearInterval(countdown);
                    $btn.text('发送验证码');
                    $btn.prop('disabled', false);
                }
                count--;
            }, 1000);

            $.ajax({
                url: 'account.php?action=send_email_code',
                method: 'POST',
                data: {
                    mail: email
                },
                success: function(response) {
                    $message.text('验证码已发送，请查收邮件').css('color', 'green');
                },
                error: function(data) {
                    $message.text(data.responseJSON.msg).css('color', 'red');
                    clearInterval(countdown);
                    $btn.text('发送验证码');
                    $btn.prop('disabled', false);
                }
            });
        });

        // 裁剪上传头像
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                if (!files[0].type.startsWith('image')) {
                    alert('只能上传图片');
                    return;
                }
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160
            });

            canvas.toBlob(function(blob) {
                uploadImage(blob, 'avatar.jpg');
            });
        });

        $('#use_original_image').click(function() {
            var blob = $('#upload_image')[0].files[0];
            uploadImage(blob, blob.name)
        });

        // 上传图片
        function uploadImage(blob, filename) {
            var formData = new FormData();
            formData.append('image', blob, filename);
            $.ajax('./blogger.php?action=update_avatar', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $modal.modal('hide');
                    if (data.code == 0) {
                        $('#avatar_image').attr('src', data.data);
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(xhr) {
                    var data = xhr.responseJSON;
                    if (data && typeof data === "object") {
                        alert(data.msg);
                    } else {
                        alert("上传头像出错了");
                    }
                }
            });
        }
    });
</script>