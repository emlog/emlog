<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!doctype html>
<html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<head>
<!--vot--><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/bootstrap.min.4.6.css" rel="stylesheet" type="text/css" type="text/css"/>
    <script src="./views/js/jquery.min.3.5.1.js" type="text/javascript"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js" type="text/javascript"></script>
    <script src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>" type="text/javascript"></script>
<!--vot--><title><?=lang('login')?></title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <form method="post" action="./index.php?action=login">
                            <div class="form-group">
<!--vot-->                      <input type="text" class="form-control form-control-user" id="user" name="user" placeholder="<?=lang('user_name')?>">
                            </div>
                            <div class="form-group">
<!--vot-->                      <input type="password" class="form-control form-control-user" id="pw" name="pw" placeholder="<?=lang('password')?>">
                            </div>
                            <?php if ($ckcode): ?>
                                <div class="form-group">
<!--vot-->                          <input type="text" name="imgcode" class="form-control" id="imgcode" placeholder="<?=lang('captcha')?>" required="required">
                                    <img src="../include/lib/checkcode.php" align="absmiddle" id="checkcode">
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
<!--vot-->                          <label class="custom-control-label" for="customCheck"><?=lang('remember_me')?></label>
                                </div>
                            </div>
<!--vot-->                  <button type="submit" class="btn btn-primary btn-user btn-block"><?=lang('login')?></button>
                        </form>
                        <hr>
                        <div class="text-center">
<!--vot-->                  <a href="../" class="btn btn-link btn-xs" role="button"><?=lang('back_home')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
