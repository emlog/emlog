<?php
/**
 * 数据库升级程序2.6.0 to 2.6.5
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

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
		$this->id = @ mysql_connect($host,$user,$pass) OR die("连接数据库失败，可能是用户名或密码错误");
	}
	function selectdb($db){
		mysql_select_db($db,$this->id) or die("未找到指定数据库!");
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
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog</title>
<style type="text/css">
<!--
body {
	background-color: #D4E9EA;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:650px;
	margin:10px 280px;
	padding:10px;
	list-style:none;
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
<form name="form1" method="post" action="up2.6.0to2.6.5.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog 2.6.0 to 2.6.5</span><span> 数据库升级程序</span></p>
</div>
<div class="b">
<p class="title2">请填写当前需要升级的emlog相关信息。<br>
  如下各个参数请参考当前emlog根目录下的 config.php 文件 认真填写。</p>
<li><strong> 服务器地址</strong>：<span class="care">(通常为localhost不必修改 对应config.php里的 $host 参数)</span> <br />
    <input name="hostname" type="text" class="input" value="localhost">
</li>
<li><strong>Mysql
    数据库用户名：</strong><span class="care">(对应config.php里的 $user 参数)</span><br />
    <input name="dbuser" type="text" class="input" value="">
</li>
<li>
    <strong>数据库用户密码：</strong><span class="care">(对应config.php里的 $pass 参数)</span><br />
  <input name="password" type="password" class="input">
</li>
<li>
    <strong>数据库名</strong>：<span class="care">(对应config.php里的 $db 参数)</span><br />
      <input name="dbname" type="text" class="input" value="">
</li>
<li>
    <strong>数据库前缀</strong>：<span class="care">(对应config.php里的 $db_prefix 参数)</span><br />
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
&copy;2007 emlog
</p>
</div>
</div>
</form>
<?php
}

if(isset($_GET['action'])&&$_GET['action'] == "install"){

	// 获取表单信息，修改配置文件
	$db_host = trim($_POST['hostname']);//服务器地址
	$db_user = trim($_POST['dbuser']);	 //mysql 数据库用户名
	$db_pw   = trim($_POST['password']);//mysql 数据库密码
	$db_name = trim($_POST['dbname']);//数据库名
	$db_prefix = trim($_POST['dbprefix']);//数据库前缀


//初始化数据库类
$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
unset($db_host, $db_user, $db_pw,$db_name);

$dbcharset = 'utf8';
$type = 'MYISAM';
$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
$extra2 = "TYPE=".$type;
$DB->version() > '4.1' ? $add = $extra:$add = $extra2.";";
//sql language
$sql = "
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT ,
content VARCHAR(255) NOT NULL ,
date VARCHAR(10) NOT NULL ,
PRIMARY KEY (id)
){$add}
ALTER TABLE {$db_prefix}config ADD index_twnum TINYINT( 3 ) UNSIGNED DEFAULT '0' NOT NULL AFTER index_tagnum;";

	$mysql_query = explode(";",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			$ret = $DB->query($query);
			if(!$ret)
			{
				exit('升级失败，可能是你填写的参数错误（特别是数据库前缀），请确认后重新提交！');
			}
		}
	}
	echo "恭喜你Emlog数据库升级成功！请删除该升级文件 <a href=\"./index.php\">进入Emlog </a>";
}
echo "</body>";
echo "</html>";
?>