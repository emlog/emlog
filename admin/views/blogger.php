<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (User::isAdmin()): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
    </div>
<?php endif; ?>
<div class="panel-heading">
    <?php if (User::isAdmin()): ?>
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
            <li class="nav-item"><a class="nav-link active" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
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
                    <label><?php _lang('nickname'); ?></label>
                    <input class="form-control" value="<?= $nickname ?>" name="name" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label><?php _lang('username'); ?></label>
                    <input class="form-control" value="<?= $username ?>" name="username" id="username">
                    <small><?php _lang('username_tip'); ?></small>
                </div>
                <label><?php _lang('email'); ?></label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="" value="<?= $email ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="button" id="button-addon2" data-toggle="modal" data-target="#editEmailModal" data-email="<?= $email ?>"><?php _lang('change'); ?></button>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php _lang('personal_description'); ?></label>
                    <?php if (User::haveEditPermission()): ?>
                        <a href="javascript:void(0);" class="ml-3" id="ai_button">✨</a>
                    <?php endif; ?>
                    <textarea name="description" class="form-control" id="description"><?= $description ?></textarea>
                </div>
                <div class="form-group">
                    <?php doAction('blogger_ext') ?>
                </div>
                <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?php _lang('save'); ?>" name="submit_form" id="submit_form" class="btn btn-sm btn-success" />
                <a href="#" type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#editPasswordModal"><?php _lang('change_password'); ?></a>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title"><?php _lang('crop_and_upload'); ?></h5>
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
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php _lang('cancel'); ?></button>
                <button type="button" id="crop" class="btn btn-sm btn-success"><?php _lang('save'); ?></button>
                <button type="button" id="use_original_image" class="btn btn-sm btn-primary"><?php _lang('use_original_image'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?php _lang('change_password'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="blogger.php?action=change_password" id="passwd_setting_form" method="post">
                    <div class="form-group">
                        <label><?php _lang('new_password_min_6'); ?></label>
                        <input type="password" class="form-control" id="new_passwd" name="new_passwd" minlength="6" required>
                        <div id="passwordHelp" class="form-text mt-1"></div>
                    </div>
                    <div class="form-group">
                        <label><?php _lang('repeat_new_password'); ?></label>
                        <input type="password" class="form-control" id="new_passwd2" name="new_passwd2" minlength="6" required>
                    </div>
                    <div class="modal-footer border-0">
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php _lang('cancel'); ?></button>
                        <button type="submit" class="btn btn-sm btn-success"><?php _lang('save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editEmailModal" tabindex="-1" role="dialog" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?php _lang('change_email'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="message"></div>
                <form action="blogger.php?action=change_email" id="email_setting_form" method="post">
                    <div class="form-group">
                        <label><?php _lang('email'); ?></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="<?php _lang('email_code'); ?>" name="mail_code" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button" id="button-send-auth-email"><?php _lang('send_verification_code'); ?></button>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php _lang('cancel'); ?></button>
                        <button type="submit" class="btn btn-sm btn-success"><?php _lang('save'); ?></button>
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
            submitForm("#passwd_setting_form", '<?php _lang('change_success_relogin'); ?>');
            $("#editPasswordModal").modal('hide');
        });

        // 修改邮箱表单提交
        $("#email_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#email_setting_form", '<?php _lang('email_change_success'); ?>');
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
            $message.empty().removeClass().show();
            var count = 60;
            var countdown = setInterval(function() {
                $btn.text('<?php _lang('resend'); ?> (' + count + ')');
                if (count == 0) {
                    clearInterval(countdown);
                    $btn.text('<?php _lang('send_verification_code'); ?>');
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
                    $message.text('<?php _lang('verification_code_sent'); ?>').addClass('alert alert-success');
                },
                error: function(data) {
                    $message.text(data.responseJSON.msg).addClass('alert alert-danger');
                    setTimeout(hideActived, 3600);
                    clearInterval(countdown);
                    $btn.text('<?php _lang('send_verification_code'); ?>');
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
                    alert('<?php _lang('only_image_allowed'); ?>');
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
                        alert("<?php _lang('upload_avatar_error'); ?>");
                    }
                }
            });
        }

        // AI 生成个人描述
        $('#ai_button').click(function() {
            $.ajax({
                url: 'ai.php?action=genBio',
                method: 'GET',
                success: function(response) {
                    $('#description').val(response.data);
                },
                error: function(xhr) {
                    alert('<?php _lang('ai_request_failed'); ?>');
                }
            });
        });

        // 密码强度检查
        $('#new_passwd').on('input', function() {
            var password = $(this).val();
            var strength = getPasswordStrength(password);
            $('#passwordHelp').text('<?php _lang('password_strength'); ?>：' + strength.text).css('color', strength.color);
        });

        function getPasswordStrength(password) {
            var strength = {
                text: '<?php _lang('weak'); ?>',
                color: 'red'
            };
            if (password.length >= 6) {
                var strengthScore = [/[A-Z]/, /[a-z]/, /\d/, /\W/].reduce((score, regex) => score + regex.test(password), 0);
                if (strengthScore >= 3) {
                    strength = {
                        text: '<?php _lang('strong'); ?>',
                        color: 'green'
                    };
                } else if (strengthScore >= 2) {
                    strength = {
                        text: '<?php _lang('medium'); ?>',
                        color: 'orange'
                    };
                }
            }
            return strength;
        }
    });
</script>