<?php
/*
@ Emlog PHP+MySQL blog system 
@ version ->2.2.0

| Copyright (c) 2005 Emlog.Net 
| Support : http://www.emlog.net  
| email :  (emloog@gmail.com) 
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
		$query =@ mysql_query($sql,$this->id); 		
			return $query;
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
	background-color: #FFFFFF;
	font-family: Verdana, PMingLiU;
	font-size: 12px;
	margin: 0px;
}
table {
	margin-top:20px;
	border-top: 1px solid #B73C00;
	border-left: 1px solid #B73C00;
	padding:10px 5px;
	font-size: 12px;
	color: #B73C00;
}
td{
	border-bottom: 1px solid  #B73C00;
	border-right:1px solid  #B73C00;
	}
input{
	border: 1px solid  #B73C00;
	font-family: "Verdana", "Arial", "Helvetica", "sans-serif";
	font-size: 12px;
	background-color: #B73C00;
	color: #FFFFFF;
}
-->
</style>
<?php
if(!isset($_GET['action'])){
?>
<form name="form1" method="post" action="up2.1.6sp1to2.2.0.php?action=install">
<table width="600" cellpadding="0" cellspacing="0" align="center" bgcolor="#f6f6f6">
  <tr>
    <td height="30" colspan="2"><H2>Emlog 2.0.0 到 2.2.0数据库升级程序 </H2>
      <p><br />
        (Emlog All rights reserved 2005-2006)
      </p></td>
  </tr>
  <tr>
    <td height="30" colspan="2"><b>请填写要升级emlog的mysql相关信息：</b><br></td>
  </tr>
  <tr>
    <td>服务器地址:(通常为localhost不必修改)</td>
    <td><input type="text" name="hostname" value="localhost"></td>
  </tr>
  <tr>
    <td>数据库用户:(Mysql数据库用户名)</td>
    <td><input type="text" name="dbuser" value="root"></td>
  </tr>
  <tr>
    <td>数据库用户密码:</td>
    <td><input type="password" name="password"></td>
  </tr>
  <tr>
    <td>数据库名:<br />
    (emlog2.1.6sp1正在使用的数据库名    )</td>
    <td><input type="text" name="dbname" value=""></td>
  </tr>
    <tr>
    <td>数据库前缀:<br />
    (emlog2.1.6sp1正在使用的数据库前缀 如：em_)</td>
    <td><input type="text" name="dbprefix" value="em_"></td>
  </tr>
    <tr>
    <td height="30" colspan="2" align="center">
        <input type="submit" name="Submit" value="下一步">
        <input type="reset" name="Submit2" value="取消">
		</td>
  </tr>
</table>
</form>
<?php
}

if(isset($_GET['action'])&&$_GET['action'] == "install"){

// 获取表单信息，修改配置文件
	$db_host = trim($_POST['hostname']);//服务器地址
	$db_user = trim($_POST['dbuser']);	 //mysql 数据库用户名
	$db_pw = trim($_POST['password']);//mysql 数据库密码
	$db_name = trim($_POST['dbname']);//数据库名
	$db_prefix = trim($_POST['dbprefix']);//数据库前缀

//错误返回函数
function msg($msg){
	   	echo "<table width=\"600\" align=\"center\" bgcolor=\"#f6f6f6\"><tr><td>".$msg."</td></tr></table>";
		exit;
}

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
ALTER TABLE ".$db_prefix."blog DROP weather;
ALTER TABLE ".$db_prefix."blog ADD comnum MEDIUMINT( 8 ) UNSIGNED DEFAULT '0' NOT NULL AFTER views;
ALTER TABLE ".$db_prefix."config CHANGE blogname blogname VARCHAR( 255 ) DEFAULT ''; 
ALTER TABLE ".$db_prefix."config CHANGE timezone timezone FLOAT DEFAULT '8'; 
ALTER TABLE ".$db_prefix."config CHANGE nonce_templet nonce_templet VARCHAR( 255 ) DEFAULT '';
DROP TABLE ".$db_prefix."templet;
DROP TABLE IF EXISTS ".$db_prefix."statistics;
CREATE TABLE ".$db_prefix."statistics (
  day_view_count int(11) unsigned NOT NULL DEFAULT '0',
  view_count int(11) unsigned NOT NULL DEFAULT '0',
  curdate varchar(20) DEFAULT ''
)".$add."
INSERT INTO ".$db_prefix."statistics (day_view_count, view_count, curdate) VALUES (0, 0, '2006-10-13');
ALTER TABLE ".$db_prefix."user ADD province VARCHAR( 20 ) NOT NULL AFTER sex;";
	
    $mysql_query = explode(";",$sql);
    while (list(,$query) = each($mysql_query)) {
           $query = trim($query);
           if ($query) {
               if (strstr($query,'CREATE TABLE')) {
                   ereg('CREATE TABLE ([^ ]*)',$query,$regs);
				   $result .= "<tr><td>表:[".$regs[1]."]创建";
				   $DB->query($query);
					if ($query){
						$result .= "成功...</td></tr>\n";
					} else {
						$result .= "失败...</td></tr>\n";
					}
               } else {
                   $DB->query($query);
               }
       }
    }
$DB->query("UPDATE ".$db_prefix."config SET nonce_templet ='default' ");
$query=$DB->query("SELECT tid,gid FROM ".$db_prefix."tag");
if($DB->num_rows($query)!=0){
	while($tid=$DB->fetch_array($query)){
		$tagid[] = $tid['tid'];
		$gid = $tid['gid'];
	}
	if(substr($gid,0,1)!=','){
		foreach($tagid as $key=>$value){
			$query=$DB->query("UPDATE ".$db_prefix."tag SET gid=CONCAT(',',gid,',') WHERE tid='$value' ");
		}
	}
}
//comnum
$query=$DB->query("SELECT gid FROM ".$db_prefix."blog");
	while($blog=$DB->fetch_array($query)){
		$blogid = $blog['gid'];
		$cquery=$DB->query("SELECT cid FROM ".$db_prefix."comment WHERE gid='$blogid' ");
		$comnum = $DB->num_rows($cquery);
		$DB->query("UPDATE ".$db_prefix."blog SET comnum='$comnum' WHERE gid='$blogid' ");
	}
echo "<table width=\"600\"  align=\"center\" bgcolor=\"#f6f6f6\">".$result;
echo "<tr><td>Emlog 数据库升级成功！</td></tr>";
echo "</table>";
echo "<table width=\"600\"  align=\"center\" bgcolor=\"#f6f6f6\">";
echo "</table>";
echo "<table width=\"600\"  align=\"center\" bgcolor=\"#f6f6f6\">";
echo "<tr><td>恭喜你Emlog数据库升级成功！请删除该升级文件</td></tr>";
echo "<tr><td><a href=\"./index.php\">进入Emlog </a></td></tr>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>