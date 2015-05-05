<?php
/**
 * emlog Password Reset Tool
 * @copyright (c) Emlog All Rights Reserved
 * Modified by Valery Votintsev, codersclub.org
 */

define('EMLOG_ROOT', dirname(__FILE__));
define('DEL_INSTALLER', 0);

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();

$act = isset($_GET['action'])? $_GET['action'] : '';

$DB = MySql::getInstance();
$CACHE = Cache::getInstance();
$sql = "SELECT username FROM ".DB_PREFIX."user  WHERE uid=1";
$row = $DB->once_fetch_array($sql);
$user_name = $row['username'] ? $row['username'] : '';

if(!$act){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
<!--
body {background-color:#F7F7F7;font-family: Arial;font-size: 14px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 14px;color: #666666;width:750px;margin:30px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid; border-radius: 4px;}
.title{text-align:center; font-size: 14px;}
.input {border: 1px solid #CCCCCC;font-family: Arial;font-size: 14px;height:20px; width: 150px;background-color:#F7F7F7;color: #666666;}
.submit{cursor: pointer;font-size: 12px;padding: 4px 10px;}
.care{color:#0066CC;}
.title2{font-size:18px;color:#666666;border-bottom: #CCCCCC 1px solid; margin:40px 0px 20px 0px;padding:10px 0px;}
.center{text-align:center;}
.main li{ margin:20px 0px;}
.notice{font-size: 16px;color:#F60;}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="passwd.php?action=chpwd">
<div class="main">
<p class="title">Reset Administrator Password</p>
<div class="b">
<p class="title2"></p>
<p class="center">Are you sure you want the administrator <span class="notice"><?php echo $user_name;?></span> password must be reset to <span class="notice"><input name="passwd" type="text" class="input" value="123456"></span> ?</p>
</div>
<div>
<p class="center">
<input type="submit" class="submit" value="OK Reset">
</p>
</div>
<p class="title2"></p>
<div class="center">&copy; emlog</div>
</div>
</form>
</body>
</html>
<?php
}
if($act == 'chpwd'){
	$adminpw = isset($_POST['passwd']) ? addslashes(trim($_POST['passwd'])) : '';

	if($adminpw == ''){
/*vot*/		emMsg('Password can not be empty!');
/*vot*/	}elseif(strlen($adminpw) < 5){
/*vot*/		emMsg('Password should not be less than 5 characters');
	}

	$PHPASS = new PasswordHash(8, true);
	$adminpw_hash = $PHPASS->HashPassword($adminpw);

	$sql = "update ".DB_PREFIX."user set password='$adminpw_hash'  WHERE uid=1";
	$DB->query($sql);

/*vot*/	$result = "
		<p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">Congratulations! Your administrator password has been reset!</p>
		<p><b>Username</b>: {$user_name}</p>
		<p><b>New password</b>: $adminpw</p>";

	if (DEL_INSTALLER === 1 && !@unlink('./passwd.php') || DEL_INSTALLER === 0) {
/*vot*/	    $result .= '<p style="color:red;margin:10px 20px;">Warning: Please delete manually the files in the installation root directory: passwd.php</p> ';
	}
/*vot*/	$result .= "<p style=\"text-align:right;\"><a href=\"./\">Go to Home</a> | <a href=\"./admin/\">Go to AdminCP</a></p>";
	emMsg($result, 'none');
}
