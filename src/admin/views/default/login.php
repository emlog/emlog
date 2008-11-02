<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<html><head>
<meta http-equiv="Content-Type" content="text/html  charset=utf-8">
<meta name="robots" content="noindex, nofollow">
<title>emlog</title>
<link rel="stylesheet" href="./views/<?php echo $nonce_tpl; ?>/main.css">
<script type="text/javascript" src="./views/<?php echo $nonce_tpl; ?>/main.js"></script>
</head>
<body bgcolor="#F9FCFE">
<form name="f" method="post" action="index.php?action=login">
<br /><br /><br /><br />
<table align="center" class="toptd">
<h3 align="center">Emlog</h3>
<tr><td width="48" >用户名:<br />
<input name="user" id="user" type="text" class="input">密码:<br />
<input name="pw" id="pw" type="password" class="input"><br>
</td></tr><?php echo $ckcode; ?><tr>
<td align="right"><input type="submit" value=" 登 录" class="submit"></td>
</tr>
</table>
</form>
<script>
focusEle('user');
</script>
</body>
</html>