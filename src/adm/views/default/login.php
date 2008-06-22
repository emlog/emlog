<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<html><head>
<meta http-equiv="Content-Type" content="text/html  charset=utf-8">
<meta name="robots" content="noindex, nofollow">
<title>emlog</title>
<link rel="stylesheet" href="./views/<?php echo $nonce_tpl; ?>/main.css">
</head>
<body bgcolor="#F9FCFE">
<form name="f" method="post" action="index.php?action=login">
<br /><br /><br /><br />
<table align="center" class="toptd">
<h3 align="center">Emlog</h3>
<tr><td width="48" >用户名:<br />
<input name="user" type="text" class="input">密码:<br />
<input name="pw" type="password" class="input"></td></tr><?php echo $ckcode; ?><tr>
<td align="right"><input type="submit" value=" 登录>>" class="submit">
</td></tr>
</table></form>
<script>var w=document.f.user;w.focus();</script>
</body>
</html>