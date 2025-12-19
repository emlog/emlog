<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-xl-6 col-lg-10 col-md-9">
            <div class="card o-hidden border-1 shadow my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?php _lang('login'); ?></h1>
                            </div>
                            <?php if (isset($_GET['succ_reg'])): ?>
                                <div class="alert alert-success"><?php _lang('register_success_login'); ?></div><?php endif ?>
                            <?php if (isset($_GET['succ_reset'])): ?>
                                <div class="alert alert-success"><?php _lang('reset_success_login'); ?></div><?php endif ?>
                            <?php if (isset($_GET['err_ckcode'])): ?>
                                <div class="alert alert-danger"><?php _lang('captcha_error'); ?></div><?php endif ?>
                            <?php if (isset($_GET['err_login'])): ?>
                                <div class="alert alert-danger"><?php _lang('user_pass_error'); ?></div><?php endif ?>
                            <?php if (isset($_GET['err_forbid'])): ?>
                                <div class="alert alert-danger"><?php _lang('account_forbidden'); ?></div><?php endif ?>
                            <form method="post" class="user" action="./account.php?action=dosignin&s=<?= $admin_path_code ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="<?php _lang('username_email'); ?>"
                                        required
                                        autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="pw" name="pw" placeholder="<?php _lang('password'); ?>" required>
                                </div>
                                <?php if ($login_code): ?>
                                    <div class="form-group form-inline">
                                        <input type="text" name="login_code" class="form-control form-control-user" style="width:180px;" id="login_code" placeholder="<?php _lang('captcha'); ?>"
                                            required>
                                        <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                    </div>
                                <?php endif ?>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="persist" name="persist" value="1">
                                        <label class="custom-control-label" for="persist"><?php _lang('remember_me'); ?></label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit"><?php _lang('login'); ?></button>
                                <?php if ($is_signup): ?>
                                    <div class="text-center my-3"><a href="./account.php?action=signup"><?php _lang('register_account'); ?></a></div>
                                <?php endif ?>
                                <div class="text-center"><?php doAction('login_ext') ?></div>
                                <hr>
                                <div class="text-center">
                                    <a href="../" class="small" role="button">&larr;<?php _lang('back_to_home'); ?></a>&nbsp&nbsp&nbsp
                                    <a class="small" href="./account.php?action=reset"><?php _lang('reset_password'); ?></a>
                                </div>
                            </form>
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
    $(function() {
        setTimeout(hideActived, 6000);
        $('#checkcode').click(function() {
            var timestamp = new Date().getTime();
            $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
        });
    });
</script>