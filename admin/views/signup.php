<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-xl-6 col-lg-10 col-md-9">
            <div class="card o-hidden border-1 shadow my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= _lang('register_account'); ?></h1>
                            </div>
                            <div class="alert alert-danger" style="display: none;" id="send-btn-resp"></div>
                            <?= FlashMsg::renderSignupAlerts(); ?>
                            <form method="post" class="user" action="./account.php?action=dosignup">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="mail" name="mail" aria-describedby="emailHelp" placeholder="<?= _lang('email'); ?>" required
                                        autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" minlength="6" id="passwd" autocomplete="new-password" name="passwd"
                                        placeholder="<?= _lang('password'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="<?= _lang('confirm_password'); ?>"
                                        required>
                                </div>
                                <?php if ($email_code): ?>
                                    <div class="form-group em-signup-inline-group">
                                        <input type="text" name="mail_code" class="form-control form-control-user em-signup-inline-input" id="mail_code" placeholder="<?= _lang('email_code'); ?>"
                                            required>
                                        <button class="btn btn-success btn-user em-signup-inline-button" type="button" id="send-btn"><?= _lang('send_email_code'); ?></button>
                                    </div>
                                <?php endif ?>
                                <?php if ($login_code): ?>
                                    <div class="form-group em-signup-inline-group">
                                        <input type="text" name="login_code" class="form-control form-control-user em-signup-inline-input" id="login_code" placeholder="<?= _lang('captcha'); ?>"
                                            required>
                                        <img src="../include/lib/checkcode.php" id="checkcode" class="em-signup-inline-image" alt="<?= _lang('captcha'); ?>">
                                    </div>
                                <?php endif ?>
                                <button class=" btn btn-success btn-user btn-block" type="submit"><?= _lang('register'); ?></button>
                                <hr>
                                <div class="text-center"><a href="./"><?= _lang('login'); ?></a></div>
                                <div class="text-center"><?php doAction('signup_ext') ?></div>
                                <hr>
                                <div class="text-center"><a href="../" class="small" role="button">&larr;<?= _lang('back_to_home'); ?></a></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    // send mail code
    $(function() {
        const sendEmailCodeText = '<?= _lang('send_email_code'); ?>';
        setTimeout(hideActived, 6000);
        $('#checkcode').click(function() {
            var timestamp = new Date().getTime();
            $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
        });

        $('#send-btn').click(function() {
            const email = $('#mail').val();
            const sendBtn = $(this);
            const sendBtnResp = $('#send-btn-resp');
            sendBtnResp.html('')
            sendBtn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: './account.php?action=send_email_code',
                data: {
                    mail: email
                },
                /**
                 * 发送邮件验证码成功的回调函数
                 * @param {Object} response 接口返回数据
                 */
                success: function(response) {
                    // 发送邮件成功后，启动倒计时
                    let seconds = 60;
                    // 启动倒计时
                    const countdownInterval = setInterval(() => {
                        seconds--;
                        if (seconds <= 0) {
                            clearInterval(countdownInterval);
                            sendBtn.html(sendEmailCodeText);
                            sendBtn.prop('disabled', false);
                        } else {
                            sendBtn.html(`${seconds}s`);
                        }
                    }, 1000);
                },
                /**
                 * 发送邮件验证码失败的回调函数，解析并展示错误信息
                 * @param {Object} xhr XMLHttpRequest对象
                 * @param {string} status 状态描述
                 * @param {string} error 错误对象
                 */
                error: function(xhr, status, error) {
                    console.error('Request failed:', error);
                    let errMsg = xhr.responseText;
                    if (xhr.responseJSON && xhr.responseJSON.msg) {
                        errMsg = xhr.responseJSON.msg;
                    } else if (xhr.responseText) {
                        try {
                            const res = JSON.parse(xhr.responseText);
                            if (res && res.msg) {
                                errMsg = res.msg;
                            }
                        } catch (e) {
                            // 保持原始文本
                        }
                    }
                    sendBtnResp.html(errMsg);
                    sendBtnResp.show();
                    sendBtn.html(sendEmailCodeText);
                    sendBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
</body>

</html>
