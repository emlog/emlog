<?php
/**
 * 数据库升级程序3.1.0 to 3.2.0
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 */

header('Content-Type: text/html; charset=UTF-8');
define('EMLOG_VERSION', '3.2.0');
define('EMLOG_ROOT', dirname(__FILE__));

class MySql {
	var $user,$pass,$host,$db;
	var $id,$data,$fields,$row,$row_num,$insertid,$version,$query_num=0;
	function MySql($host,$user,$pass,$db) {
		$this->host = $host;
		$this->pass = $pass;
		$this->user = $user;
		$this->db = $db;
		$this->dbconnect($this->host, $this->user, $this->pass);
		$this->selectdb($this->db);
		if($this->version() >'4.1')
		mysql_query("SET NAMES 'utf8'");
	}
	function dbconnect($host,$user,$pass){
		$this->id = @ mysql_connect($host,$user,$pass) OR emMsg("连接数据库失败，可能是用户名或密码错误");
	}
	function selectdb($db){
		mysql_select_db($db,$this->id) or emMsg("未找到指定数据库");
	}

	function query($sql) {
		$ret = @ mysql_query($sql,$this->id);
		return $ret;
	}
	function fetch_array($query){
		$this->data = @mysql_fetch_array($query);
		return $this->data;
	}
	function num_rows($query) {
		$this->row_num = @mysql_num_rows($query);
		return $this->row_num;
	}
	function version() {
		$this->version = mysql_get_server_info();
		return $this->version;
	}
	function geterror()
	{
		return mysql_error();
	}
}

function getRandStr($length = 12, $special_chars = true)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars )
	{
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}
/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 */
function emMsg($msg,$url='javascript:history.back(-1);')
{
echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog system message</title>
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
	width:560px;
	margin:10px 200px;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">&laquo;返回</a></p>
</div>
</body>
</html>
EOT;
exit;
}
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
<li><strong> 服务器地址</strong>：<span class="care">(通常为localhost不必修改)</span> <br />
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
	}else{
		$result.="配置文件修改成功<br />";
	}
	fclose($fp);

	//初始化数据库类
	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	unset($db_host, $db_user, $db_pw,$db_name);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
	$extra2 = "TYPE=".$type;
	$DB->version() > '4.1' ? $add = $extra:$add = $extra2.";";
	
	$res = $DB->query("select * from {$db_prefix}statistics");
	$row = $DB->fetch_array($res);
	@extract($row);

$sql = "
ALTER TABLE {$db_prefix}blog ADD author INT( 10 ) NOT NULL DEFAULT '1' AFTER excerpt;
ALTER TABLE {$db_prefix}blog ADD type VARCHAR( 20 ) NOT NULL DEFAULT 'blog' AFTER sortid;
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_day','$day_view_count');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_all','$view_count');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('viewcount_date','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','a:1:{i:0;s:13:\"tips/tips.php\";}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('navibar','a:0:{}');
DROP TABLE IF EXISTS {$db_prefix}statistics;
ALTER TABLE {$db_prefix}user ADD role VARCHAR( 60 ) NOT NULL AFTER nickname;
ALTER TABLE {$db_prefix}user CHANGE description description VARCHAR( 255 ) NOT NULL;
UPDATE {$db_prefix}user SET role = 'admin' WHERE uid =1 LIMIT 1;";

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
	emMsg("恭喜你emlog数据库升级成功！请删除该升级文件,你现在可以进行第二步 代码升级");
}
echo "</body>";
echo "</html>";
?>