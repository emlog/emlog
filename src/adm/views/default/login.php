<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<html><head>
<meta http-equiv="Content-Type" content="text/html  charset=utf-8">
<meta name="robots" content="noindex, nofollow">
<title>emlog</title>
<link rel="stylesheet" href="./views/<?php echo $nonce_tpl; ?>/main.css">
<script src="../lib/js/common_tpl.js" language="javascript"></script>
<script language="Javascript">
function autoLogin()
{
	var url = document.location.href;
	if(url.indexOf('?') == -1)
	{
		var user = GetCookie('user');
		var pw   = GetCookie("pw");
		var isR  = GetCookie("isRemember");
		if(user != null ) 
		{
			$("user").value = user;
		}
		if(pw != null )
		{
			$("pw").value = pw.substring(0,16);
		}
		if(isR == 'true') 
		{
			$("isRemember").checked = true;
		}
	}
	
}

function saveUser()
{
	var user = $('user').value;
	var pw   = $('pw').value;
	var isR  = $('isRemember').checked ? true : false;
	if(isR)
	{
		SetCookie('user',user);
		SetCookie('pw',pw);
		SetCookie('isRemember','true');
	}
}
</script>
</head>
<body bgcolor="#F9FCFE">
<form name="f" method="post" action="index.php?action=login" onSubmit="saveUser();">
<br /><br /><br /><br />
<table align="center" class="toptd">
<h3 align="center">Emlog</h3>
<tr><td width="48" >用户名:<br />
<input name="user" id="user" type="text" class="input">密码:<br />
<input name="pw" id="pw" type="password" class="input"><br>
<input type="checkbox" value="true" id="isRemember">记住
</td></tr><?php echo $ckcode; ?><tr>
<td align="right"><input type="submit" value=" 登录>>" class="submit"></td>
</tr>
</table>
</form>
<script>
focusEle('user');
autoLogin();
</script>
</body>
</html>