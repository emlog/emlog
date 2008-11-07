<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<html><head>
<meta http-equiv="Content-Type" content="text/html  charset=utf-8">
<meta name="robots" content="noindex, nofollow">
<title>emlog</title>
<link rel="stylesheet" href="./views/<?php echo ADMIN_TPL; ?>/main.css">
<script type="text/javascript" src="./views/<?php echo ADMIN_TPL; ?>/common.js"></script>
</head>
<body bgcolor="#F9FCFE">
<form name="f" method="post" action="index.php?action=login">
<br /><br /><br /><br />
<table align="center" class="toptd">
<h3 align="center">Emlog</h3>
<tr><td>
用户名:<br /><input name="user" id="user" type="text" class="input"><br>
密码:<br /><input name="pw" id="pw" type="password" class="input"><br>
<?php echo $ckcode; ?><br>
</td></tr>
<tr><td>
<input type="checkbox" id="ispersis" name="ispersis" value="1" /><label for="ispersis">记住我</label>
</td></tr>
<tr><td align="right"><input type="submit" value=" 登 录" class="submit"></td></tr>
</table>
</form>
<script>
focusEle('user');
</script>
</body>
</html>