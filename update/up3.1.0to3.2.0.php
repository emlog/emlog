<?php
/**
 * 数据库升级程序3.1.0 to 3.2.0
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 */

header('Content-Type: text/html; charset=UTF-8');
define('EMLOG_VERSION', '3.2.0');
define('EMLOG_ROOT', dirname(__FILE__));

require_once('./lib/F_base.php');
require_once('./lib/C_mysql.php');
require_once('./lib/C_cache.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog 数据库升级程序</title>
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
<form name="form1" method="post" action="up3.1.0to3.2.0.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog 3.1.0 to 3.2.0</span><span> 数据库升级程序</span></p>
</div>
<div class="b">
<p class="title2">请填写当前需要升级的emlog相关信息。<br>
  如下各个参数请参考服务器上emlog根目录下的 config.php 文件 认真填写。</p>
<li><strong> 服务器地址</strong>：<span class="care">(服务器上config.php文件里 DB_HOST 对应值)</span> <br />
    <input name="hostname" type="text" class="input" value="localhost">
</li>
<li><strong>Mysql
    数据库用户名：</strong><span class="care">(服务器上config.php文件里 DB_USER 对应值)</span><br />
    <input name="dbuser" type="text" class="input" value="">
</li>
<li>
    <strong>数据库用户密码：</strong><span class="care">(服务器上config.php文件里 DB_PASSWD 对应值)</span><br />
  <input name="password" type="password" class="input">
</li>
<li>
    <strong>emlog的数据库名</strong>：<span class="care">(服务器上config.php文件里 DB_NAME 对应值)</span><br />
      <input name="dbname" type="text" class="input" value="">
</li>
<li>
    <strong>emlog的数据库前缀</strong>：<span class="care">(服务器上config.php文件里 DB_PREFIX 对应值)</span><br />
  <input name="dbprefix" type="text" class="input" value="">
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
	// 获取表单信息，修改配置文件
	$db_host = trim($_POST['hostname']);//服务器地址
	$db_user = trim($_POST['dbuser']);	 //mysql 数据库用户名
	$db_pw   = trim($_POST['password']);//mysql 数据库密码
	$db_name = trim($_POST['dbname']);//数据库名
	$db_prefix = trim($_POST['dbprefix']);//数据库前缀

	@$fp = fopen("config.php", 'w');
	if(!$fp)
	{
		emMsg('配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写');
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
	."\n//blog root\n"
	."define('EMLOG_ROOT','".EMLOG_ROOT."');"
	."\n//blog version\n"
	."define('EMLOG_VERSION','".EMLOG_VERSION."');"
	."\n?>";

	@$fw = fwrite($fp, $config) ;
	if (!$fw)
	{
		emMsg('抱歉！配置文件(config.php)修改失败!请检查该文件是否可写');
	}

	fclose($fp);

	//初始化数据库类
	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	//数据缓存对象
	$CACHE = new mkcache($DB, $db_prefix);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
	$extra2 = "TYPE=".$type;
	$DB->getMysqlVersion() > '4.1' ? $add = $extra:$add = $extra2.";";
	
	$res = $DB->query("select * from {$db_prefix}statistics");
	$row = $DB->fetch_array($res);
	@extract($row);

$sql = "
ALTER TABLE {$db_prefix}blog ADD author INT( 10 ) NOT NULL DEFAULT '1' AFTER excerpt;
ALTER TABLE {$db_prefix}blog ADD type VARCHAR( 20 ) NOT NULL DEFAULT 'blog' AFTER sortid;
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_day','$day_view_count');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_all','$view_count');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_date','$curdate');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','a:1:{i:0;s:13:\"tips/tips.php\";}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('navibar','a:0:{}');
DROP TABLE IF EXISTS {$db_prefix}statistics;
ALTER TABLE {$db_prefix}user ADD role VARCHAR( 60 ) NOT NULL AFTER nickname;
ALTER TABLE {$db_prefix}user CHANGE description description VARCHAR( 255 ) NOT NULL;
UPDATE {$db_prefix}user SET role = 'admin' WHERE uid =1 LIMIT 1;
UPDATE {$db_prefix}options SET option_value = 'default' WHERE option_name='nonce_templet';";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			$ret = $DB->query($query);
			if(!$ret)
			{
				emMsg("升级失败，可能是你填写的参数错误，请确认后重新提交！SQL:$query MYSQL ERROR:".$DB->geterror());
			}
		}
	}
	
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

	emMsg("恭喜你！emlog已成功升级到3.2.0 <a href=\"./\"> 进入博客&raquo; </a>");
}
echo "</body>";
echo "</html>";
?>