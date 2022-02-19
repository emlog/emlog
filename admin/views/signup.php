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
<!--vot-->                          <h1 class="h4 text-gray-900 mb-4"><?=lang('account_register')?></h1>
                                </div>
								<?php if (isset($_GET['err_ckcode'])): ?>
<!--vot-->                          <div class="alert alert-danger"><?=lang('validation_error')?></div><?php endif ?>
								<?php if (isset($_GET['error_login'])): ?>
<!--vot-->                          <div class="alert alert-danger"><?=lang('email_format_error')?></div><?php endif ?>
								<?php if (isset($_GET['error_exist'])): ?>
<!--vot-->                          <div class="alert alert-danger"><?=lang('email_in_use')?></div><?php endif ?>
								<?php if (isset($_GET['error_pwd_len'])): ?>
<!--vot-->                          <div class="alert alert-danger"><?=lang('password_short')?></div><?php endif ?>
								<?php if (isset($_GET['error_pwd2'])): ?>
<!--vot-->                          <button class="btn btn-success btn-user btn-block" type="submit"><?=lang('register')?></button>
<!--vot-->                <div class="alert alert-danger"><?=lang('password_not_equal')?></div><?php endif ?>
                                <form method="post" class="user" action="./account.php?action=dosignup">
                                    <div class="form-group">
<!--vot-->                              <input type="email" class="form-control form-control-user" id="mail" name="mail" aria-describedby="emailHelp" placeholder="<?=lang('user_name')?>" required
                                               autofocus>
                                    </div>
                                    <div class="form-group">
<!--vot-->                              <input type="password" class="form-control form-control-user" minlength="5" id="passwd" name="passwd" placeholder="<?=lang('password')?>" required>
                                    </div>
                                    <div class="form-group">
<!--vot-->                              <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="<?=lang('password_confirm')?>" required>
                                    </div>
									<?php if ($login_code): ?>
                                        <div class="form-group form-inline">
<!--vot-->                                  <input type="text" name="login_code" class="form-control form-control-user" id="login_code" placeholder="<?=lang('captcha')?>" required>
                                            <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                        </div>
									<?php endif ?>
<!--vot-->                          <button class="btn btn-success btn-user btn-block" type="submit"><?=lang('register')?></button>
                                    <hr>
<!--vot-->         <!--vot-->       <div class="text-center"><a <!--href="./admin"><?=lang('log_in')?></a></div>
                                    <hr>
<!--vot-->                          <div class="text-center"><a href="../" class="small" role="button">&larr;<?=lang('back_home')?></a></div>
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
