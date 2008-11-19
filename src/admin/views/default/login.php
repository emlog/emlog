<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<html><head>
<meta http-equiv="Content-Type" content="text/html  charset=utf-8">
<meta name="robots" content="noindex, nofollow">
<title>emlog</title>
<link rel="stylesheet" href="./views/<?php echo ADMIN_TPL; ?>/main.css">
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
</head>
<body id="center">
<form name="f" method="post" action="index.php?action=login">
<div class="login_page">
<div id="login_logo"></div>
<div class="login_main">
<p>用户名</p>
<p><input name="user" id="user" type="text" class="login_input"></p>
<p>密码</p>
<p><input name="pw" id="pw" type="password" class="login_input"></p>
<?php echo $ckcode; ?>
<p>
<input type="checkbox" id="ispersis" name="ispersis" value="1" /><label for="ispersis">记住我</label>
<span style="margin-left:80px;"><input type="submit" value=" 登 录" class="submit"></span>
</p>
</div>
<div><a href="../">&laquo;返回首页</a></div>
</div>
</form>
<script>focusEle('user');</script>
</body>
</html>