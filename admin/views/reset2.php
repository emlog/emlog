<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-10 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?= lang('password_recover') ?></h1>
                                </div>
                                <form method="post" class="user" action="./account.php?action=doreset2">
									<?php if (isset($_GET['succ_mail'])): ?>
                                        <div class="alert alert-success"><?= lang('enter_code_from_email') ?></div><?php endif ?>
									<?php if (isset($_GET['err_mail_code'])): ?>
                                        <div class="alert alert-danger"><?= lang('verification_error') ?></div><?php endif ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="mail_code" name="mail_code"
                                               placeholder="<?= lang('email_verification_code') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="passwd" name="passwd"
                                               placeholder="<?= lang('new_password') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd"
                                               placeholder="<?= lang('confirm_password') ?>" required>
                                    </div>
                                    <button class="btn btn-success btn-user btn-block" type="submit"><?= lang('submit') ?></button>
                                    <hr>
                                    <div class="text-center"><a class="small" href="/admin"><?= lang('login') ?></a></div>
                                    <hr>
                                    <div class="text-center"><a href="../" class="small" role="button">&larr;<?= lang('back_home') ?></a></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    setTimeout(hideActived, 6000);
    $('#checkcode').click(function () {
        var timestamp = new Date().getTime();
        $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
    });
</script>
