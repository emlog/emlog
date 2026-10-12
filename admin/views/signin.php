<?php
defined('EMLOG_ROOT') || exit('access denied!');
$init_login_type = (Input::getStrVar('type', 'pwd') === 'code' && $login_email_code) ? 'code' : 'pwd';
?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-xl-6 col-lg-10 col-md-9">
            <div class="card o-hidden border-1 shadow my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= _lang('login'); ?></h1>
                            </div>
                            <?php if ($login_email_code): ?>
                                <div class="text-center mb-4">
                                    <a href="javascript:void(0);" class="em-login-tab-link mx-2 <?= $init_login_type === 'pwd' ? 'active' : '' ?>" id="tab-login-pwd"><?= _lang('login_by_pwd'); ?></a>
                                    <a href="javascript:void(0);" class="em-login-tab-link mx-2 <?= $init_login_type === 'code' ? 'active' : '' ?>" id="tab-login-code"><?= _lang('login_by_code'); ?></a>
                                </div>
                            <?php endif; ?>
                            <div id="signin-alert-box"><?= FlashMsg::renderSigninAlerts(); ?></div>
                            <form method="post" class="user" action="./account.php?action=dosignin&s=<?= htmlspecialchars($admin_path_code, ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="login_type" id="login_type" value="<?= $init_login_type ?>">
                                <div id="pane-pwd" <?= $init_login_type === 'code' ? 'style="display: none;"' : '' ?>>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="<?= _lang('username_email'); ?>"
                                            <?= $init_login_type === 'code' ? 'disabled' : 'required autofocus' ?>>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="pw" name="pw" placeholder="<?= _lang('password'); ?>" <?= $init_login_type === 'code' ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                                <?php if ($login_email_code): ?>
                                    <div class="pane-code" id="pane-code-mail" <?= $init_login_type === 'code' ? '' : 'style="display: none;"' ?>>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="mail" name="mail" placeholder="<?= _lang('email'); ?>" <?= $init_login_type === 'code' ? 'required autofocus' : 'disabled' ?>>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <?php if ($login_code): ?>
                                    <div class="form-group em-login-captcha-group" id="pane-captcha">
                                        <input type="text" name="login_code" class="form-control form-control-user em-login-captcha-input" id="login_code" placeholder="<?= _lang('captcha'); ?>"
                                            required autocomplete="off">
                                        <img src="../include/lib/checkcode.php" id="checkcode" class="em-login-captcha-image" alt="<?= _lang('captcha'); ?>">
                                    </div>
                                <?php endif ?>
                                <?php if ($login_email_code): ?>
                                    <div class="pane-code" id="pane-code-verify" <?= $init_login_type === 'code' ? '' : 'style="display: none;"' ?>>
                                        <div class="form-group em-signup-inline-group">
                                            <input type="text" name="mail_code" class="form-control form-control-user em-signup-inline-input" id="mail_code" placeholder="<?= _lang('email_code'); ?>" <?= $init_login_type === 'code' ? 'required' : 'disabled' ?>>
                                            <button class="btn btn-outline-primary btn-user em-signup-inline-button" type="button" id="send-login-code-btn"><?= _lang('send_email_code'); ?></button>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="persist" name="persist" value="1">
                                        <label class="custom-control-label" for="persist"><?= _lang('remember_me'); ?></label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit"><?= _lang('login'); ?></button>
                                <?php if ($is_signup): ?>
                                    <div class="text-center my-3"><a href="./account.php?action=signup"><?= _lang('register_account'); ?></a></div>
                                <?php endif ?>
                                <div class="text-center"><?php doAction('login_ext') ?></div>
                                <hr>
                                <div class="text-center">
                                    <a href="../" class="small" role="button">&larr;<?= _lang('back_to_home'); ?></a>&nbsp&nbsp&nbsp
                                    <a class="small" href="./account.php?action=reset"><?= _lang('reset_password'); ?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .em-login-tab-link {
        font-size: 0.95rem;
        color: #858796;
        text-decoration: none !important;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    .em-login-tab-link:hover {
        color: #4e73df;
    }
    .em-login-tab-link.active {
        color: #4e73df;
        font-weight: 600;
    }
    .user .btn,
    .user .form-control {
        box-shadow: none !important;
        transform: none !important;
    }
    .user .form-control:focus {
        border-color: #bac8f3 !important;
        box-shadow: none !important;
    }
</style>
<script>
    $(function() {
        setTimeout(hideActived, 6000);
        var signinAlertTimer = null;

        function showSigninAlert(type, message) {
            var alertHtml = '<div class="alert alert-' + type + '">' + message + '</div>';
            $('#signin-alert-box').html(alertHtml).show();
            clearTimeout(signinAlertTimer);
            signinAlertTimer = setTimeout(hideActived, 6000);
        }

        $('#checkcode').click(function() {
            var timestamp = new Date().getTime();
            $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
        });

        $('#tab-login-pwd').click(function() {
            if ($(this).hasClass('active')) return;
            $(this).addClass('active');
            $('#tab-login-code').removeClass('active');
            $('#login_type').val('pwd');
            $('.pane-code').hide().find('input').prop('disabled', true).prop('required', false);
            $('#pane-pwd').show().find('input').prop('disabled', false).prop('required', true);
            $('#signin-alert-box').empty();
            $('#user').focus();
        });

        $('#tab-login-code').click(function() {
            if ($(this).hasClass('active')) return;
            $(this).addClass('active');
            $('#tab-login-pwd').removeClass('active');
            $('#login_type').val('code');
            $('#pane-pwd').hide().find('input').prop('disabled', true).prop('required', false);
            $('.pane-code').show().find('input').prop('disabled', false).prop('required', true);
            $('#signin-alert-box').empty();
            $('#mail').focus();
        });

        $('#send-login-code-btn').click(function() {
            var email = $.trim($('#mail').val());
            var sendBtn = $(this);
            if (!email) {
                $('#mail').focus();
                showSigninAlert('danger', '<?= _lang('email_format_error'); ?>');
                return;
            }
            var postData = { mail: email };
            var $loginCode = $('#login_code');
            if ($loginCode.length) {
                var captcha = $.trim($loginCode.val());
                if (!captcha) {
                    $loginCode.focus();
                    showSigninAlert('danger', '<?= _lang('captcha_error'); ?>');
                    return;
                }
                postData.login_code = captcha;
            }
            sendBtn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: './account.php?action=send_login_email_code',
                data: postData,
                success: function(resp) {
                    showSigninAlert('success', '<?= _lang('email_code_sent'); ?>');
                    var seconds = 60;
                    sendBtn.text(seconds + 's');
                    var timer = setInterval(function() {
                        seconds--;
                        if (seconds <= 0) {
                            clearInterval(timer);
                            sendBtn.text('<?= _lang('send_email_code'); ?>').prop('disabled', false);
                        } else {
                            sendBtn.text(seconds + 's');
                        }
                    }, 1000);
                },
                error: function(xhr) {
                    var errMsg = '<?= _lang('email_code_send_failed'); ?>';
                    if (xhr.responseJSON && xhr.responseJSON.msg) {
                        errMsg = xhr.responseJSON.msg;
                    }
                    showSigninAlert('danger', errMsg);
                    sendBtn.prop('disabled', false);
                    if ($('#checkcode').length) {
                        $('#checkcode').click();
                    }
                }
            });
        });
    });
</script>
</body>

</html>
