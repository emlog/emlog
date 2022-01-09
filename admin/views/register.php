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
                                <form method="post" class="user" action="./account.php?action=register&s=<?= $admin_path_code ?>">
									<?php if ($error_msg): ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<?= $error_msg ?>
                                        </div>
									<?php endif ?>
                                    <div class="form-group">
<!--vot-->                              <input type="email" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="<?=lang('user_name')?>" required
                                               autofocus>
                                    </div>
                                    <div class="form-group">
<!--vot-->                              <input type="password" class="form-control form-control-user" minlength="5" id="passwd" name="passwd" placeholder="<?=lang('password')?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="<?=lang('password_confirm')?>" required>
                                    </div>
									<?php if ($ckcode): ?>
                                        <div class="form-group form-inline">
<!--vot-->                                  <input type="text" name="imgcode" class="form-control form-control-user" id="imgcode" placeholder="<?=lang('captcha')?>" required>
                                            <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                        </div>
									<?php endif ?>

<!--vot-->                          <button class="btn btn-success btn-user btn-block" type="submit"><?=lang('register')?></button>
                                    <div><?php doAction('login_ext') ?></div>
                                    <hr>
<!--vot-->                          <div class="text-center"><a class="small" href="./admin"><?=lang('log_in')?></a></div>
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
    setTimeout(hideActived, 3600);
    $('#checkcode').click(function () {
        var timestamp = new Date().getTime();
        $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
    });
</script>
