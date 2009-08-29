<?php
/**
 * 升级程序3.2.1 to 3.3.0
 * @copyright (c) Emlog All Rights Reserved
 */

header('Content-Type: text/html; charset=UTF-8');
define('EMLOG_VERSION', '3.3.0');
define('EMLOG_ROOT', dirname(__FILE__));
define('ICON_MAX_W', 140);
define('ICON_MAX_H', 220);

require_once('./config.php');
require_once('./lib/F_base.php');
require_once('./lib/C_mysql.php');
require_once('./lib/C_cache.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog 升级程序</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:580px;
	margin:10px auto;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.input {
	border: 1px solid #CCCCCC;
	font-family: Arial;
	font-size: 18px;
	height:28px;
	background-color:#F7F7F7;
	color: #666666;
	margin:5px 25px;
}
.submit{
	background-color:#FFFFFF;
	border: 3px double #999;
	border-left-color: #ccc;
	border-top-color: #ccc;
	color: #333;
	padding: 0.25em;
	cursor:hand;
}
.title{
	font-size:20px;
	font-weight:bold;
}
.care{
	color:#0066CC;
	padding:0px 10px;
}
.title2{
	font-size:14px;
	color:#000000;
	border-bottom: #CCCCCC 1px solid;
}
.foot{
	text-align:center;
}
li{
	border-bottom:#CCCCCC 1px dotted;
	margin:20px 20px;
}
-->
</style>
<?php
if(!isset($_GET['action'])){
?>
<form name="form1" method="post" action="up3.2.1to3.3.0.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog <span style="color: #0099FF">3.2.1</span> to <span style="color: #FF0000; font-size:26px">3.3.0</span></span><span> 升级程序</span></p>
<p style="color: #FF0000;">你当前处于升级步骤的第二步，请确保第一步覆盖代码的操作已完成，再进行本步操作。</p>
<p>详细升级步骤见升级程序包内的：升级说明.html</p>
</ul>
</div>
<div class="b">
<p class="title2"></p>
<li>
    <strong>数据库用户密码：</strong><span class="care">(服务器上config.php文件里 DB_PASSWD 对应值)</span><br />
  <input name="password" type="password" class="input" value="">
</li>
</div>
<div>
<p class="foot">
<input name="Submit" type="submit" class="submit" value="确 定">
<input name="Submit2" type="reset" class="submit" value="重 置">
</p>
</div>
<p class="foot">
&copy;2009 emlog
</p>
</div>
</div>
</form>
<?php
}

if(isset($_GET['action'])&&$_GET['action'] == "install")
{
	$db_host = DB_HOST;
	$db_user = DB_USER;
	$db_pw   = trim($_POST['password']);
	$db_name = DB_NAME;
	$db_prefix = DB_PREFIX;

	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	$CACHE = new mkcache($DB, $db_prefix);

	if(!is_writable('config.php'))
	{
		emMsg('配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写');
	}

$sql = "
ALTER TABLE {$db_prefix}comment ADD ip VARCHAR(128) NOT NULL AFTER url;
UPDATE {$db_prefix}options SET option_value = 'default' WHERE option_name='nonce_templet';
";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			$DB->query($query);
		}
	}

	$config = "<?php\n"
	."//mysql database address\n"
	."define('DB_HOST','$db_host');"
	."\n//mysql database user\n"
	."define('DB_USER','$db_user');"
	."\n//database password\n"
	."define('DB_PASSWD','$db_pw');"
	."\n//database name\n"
	."define('DB_NAME','$db_name');"
	."\n//database prefix\n"
	."define('DB_PREFIX','$db_prefix');"
	."\n//auth key\n"
	."define('AUTH_KEY','".getRandStr(32).md5($_SERVER['HTTP_USER_AGENT'])."');"
	."\n//cookie name\n"
	."define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_".getRandStr(32,false)."');"
	."\n?>";

	$fp = @fopen('config.php', 'w');
	$fw = @fwrite($fp, $config) ;
	if (!$fw)
	{
		emMsg('抱歉！配置文件(config.php)修改失败!请检查该文件是否可写');
	}

	fclose($fp);
	
	$CACHE->mc_user();
	$CACHE->mc_options();
	$CACHE->mc_record();
	$CACHE->mc_comment();
	$CACHE->mc_logtags();
	$CACHE->mc_logsort();
	$CACHE->mc_logatts();
	$CACHE->mc_sta();
	$CACHE->mc_link();
	$CACHE->mc_tags();
	$CACHE->mc_sort();
	$CACHE->mc_twitter();
	$CACHE->mc_newlog();

	emMsg("恭喜你！emlog已成功升级到3.3.0 <a href=\"./\"> 进入博客&raquo; </a>");
}
echo "</body>";
echo "</html>";
?>