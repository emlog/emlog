<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<!doctype html>
<html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
<!--vot--><title><?=lang('login')?></title>
    <link rel="stylesheet" type="text/css" href="./views/css/bootstrap-sbadmin-4.5.3.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>">
    <script src="./views/js/jquery.min.3.5.1.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
    <script src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-5 col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <form method="post" action="./index.php?action=login&s=<?php echo $admin_path_code; ?>">
							<?php if ($error_msg): ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<?php echo $error_msg; ?>
                                </div>
							<?php endif; ?>
                            <div class="form-group">
<!--vot-->                      <input type="text" class="form-control form-control-user" id="user" name="user" placeholder="<?=lang('user_name')?>" required autofocus>
                            </div>
                            <div class="form-group">
<!--vot-->                      <input type="password" class="form-control form-control-user" id="pw" name="pw" placeholder="<?=lang('password')?>" required>
                            </div>
							<?php if ($ckcode): ?>
                                <div class="form-group form-inline">
<!--vot-->                          <input type="text" name="imgcode" class="form-control" id="imgcode" placeholder="<?=lang('captcha')?>" required>
                                    <img src="../include/lib/checkcode.php" align="absmiddle" id="checkcode" class="mx-2">
                                </div>
							<?php endif; ?>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ispersis" id="ispersis" value="1">
<!--vot-->                          <label class="form-check-label" for="gridCheck"><?=lang('remember_me')?></label>
                                </div>
                            </div>
<!--vot-->                  <button type="submit" class="btn btn-primary btn-user btn-block"><?=lang('login')?></button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <div class="login-ext"><?php doAction('login_ext'); ?></div>
<!--vot-->                  <div><a href="../" class="btn btn-link btn-xs" role="button">&larr;<?=lang('back_home')?></a></div>
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
