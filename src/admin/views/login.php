<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="./views/css/css-login.css" type="text/css" media="screen" /> 
<script type="text/javascript" src="./views/js/common.js"></script>
<title>登录</title>
</head>
<body>
<form name="f" method="post" action="./index.php?action=login">
<div class="login-main">
	<div class="login-top"></div>
	<div class="login-logo"><a href="http://www.emlog.net" target="_blank"><img src="./views/images/login_logo.png" alt="emlog" width="294" height="68" /></a></div>
	<div class="login-input">
		<span>用户名</span>
		<div><input type="text" name="user" id="user" /></div>
		<span>密码</span>
		<div><input type="password" name="pw" id="pw" /></div>
		<?php echo $ckcode; ?>
	</div>
	<div class="login-button">
	<div class="checkbox"> <input type="checkbox" name="ispersis" id="ispersis" value="1" /><span><label for="ispersis">记住我</label></span></div>
	<div class="button"><input type="submit" value=" 登 录" class="submit"></div>
	</div>
	<div style=" clear:both;"></div>
	<div class="login-ext"><?php doAction('login_ext'); ?></div>
	<div class="login-bottom"></div>
	<div class="back"><a href="../">&laquo;返回首页</a> | <a href="http://wiki.emlog.net/doku.php?id=chpwd" target="_blank">忘记密码?</a></div>
</div>
<?php if ($error_msg): ?>
<div class="login-error"><?php echo $error_msg; ?></div>
<?php endif;?>
</form>
<script>focusEle('user');</script>
</body>
</html>
