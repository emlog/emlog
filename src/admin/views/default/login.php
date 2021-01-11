<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!DOCTYPE html>
<html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<!--vot--><head>
<!--vot--><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./views/<?php echo ADMIN_TEMPLATE; ?>/css/css-login.css?v=<?= Option::EMLOG_VERSION ?>" type="text/css" media="screen">
<link href="<?= BLOG_URL ?>admin/views/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="<?= BLOG_URL ?>include/lib/js/jquery/jquery-1.11.0.js?v=<?= Option::EMLOG_VERSION ?>"></script>
<script src="<?= BLOG_URL ?>admin/views/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./views/<?php echo ADMIN_TEMPLATE; ?>/js/common.js?v=<?= Option::EMLOG_VERSION ?>"></script>
<!--vot--><title><?=lang('login')?></title>
</head>
<body>
<div id="main" class="container">
	<form name="f" method="post" action="./index.php?action=login" class="form-horizontal">
	<br>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
			<?php if ($error_msg): ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <?= $error_msg ?>
				</div>
			<?php endif;?>
			</div>
		</div>
		<div class="form-group">
			<label for="user" class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<input type="text" name="user" class="form-control" id="user" placeholder="<?=lang('user_name')?>" required="required">
			</div>
		</div>
		<div class="form-group">
			<label for="pw" class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<input type="password" name="pw" class="form-control" id="pw" placeholder="<?=lang('password')?>" required="required">
			</div>
		</div>
		<?php
		if ($ckcode) {
			?>
			<div class="form-group">
				<label for="imgcode" class="col-sm-2 control-label"></label>
				<div class="col-sm-7">
<!--vot-->				<input type="text" name="imgcode" class="form-control" id="imgcode" placeholder="<?=lang('captcha')?>" required="required">
				</div>
				<img src="../include/lib/checkcode.php" align="absmiddle" id="checkcode">
			</div>
		<?php } ?>
		<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <div class="checkbox">
	        <label>
<!--vot-->        <input type="checkbox" name="ispersis"><?=lang('remember_me')?>
	        </label>
	      </div>
	    </div>
	  </div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
<!--vot-->			<button type="submit" id="login" class="btn btn-lg btn-success"><?=lang('login')?></button>
			</div>
		</div>
	</form>
	<div class="login-ext"><?php doAction('login_ext'); ?></div>
	<div id="small-buttons">
<!--vot-->	<a href="../" class="btn btn-link btn-xs" role="button"><?=lang('back_home')?></a>
	</div>
</div>

<script>focusEle('user');</script>
</body>
</html>
