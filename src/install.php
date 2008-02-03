<?php
/**
 * 安装程序
 * @copyright (c) 2008, Emlog All rights reserved.
 * @version emlog-2.5.0
 */

require_once('./lib/F_base.php');
require_once("./lib/C_mysql.php");
require_once('./lib/C_cache.php');

doStripslashes();

if(!isset($_GET['action'])){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog</title>
<style type="text/css">
<!--
body {
	background-color:#D4E9EA;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:500px;
	margin:10px 200px;
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
-->
</style>
</head>
<body>
<form name="form1" method="post" action="install.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog 2.5.0</span><span> 安装程序</span></p>
</div>
<div class="a">
<p class="title2">1.权限设置</p>
Linux 系统请在执行安装程序之前设置如下文件或目录权限为777：(Win系统无需设置)<br>
./config.php（文件）<br>
./cache/（目录下所有文件）<br>
./upload（目录）<br>
./admin/bakup（目录）<br>
 请确保上面的权限正确设置，才能进行安装。</p>
</div>
<div class="b">
<p class="title2">2.Mysql数据库配置</p>
<li>
    服务器地址:(通常为localhost不必修改) <br />
    <input name="hostname" type="text" class="input" value="localhost">
</li>
<li>Mysql
    数据库用户名<br />
    <input name="dbuser" type="text" class="input" value="">
</li>
<li>
    数据库用户密码:<br />
  <input name="password" type="password" class="input">
</li>
<li>
    数据库名:
	  <br>
	  <span class="care">(请提前自行创建空数据库或使用已有数据库)</span><br />
      <input name="dbname" type="text" class="input" value="">
</li>
<li>
    数据库前缀:<br>
    <span class="care"> (由英文字母、数字、下划线组成，且必须以下划线结束。
    例如："abc123_" )</span><br />
  <input name="dbprefix" type="text" class="input" value="">
</li>
</div>
<div class="c">
<p class="title2">3.管理员设置</p>
<li>
管理员 <span class="care">(后台登录)</span><br />
    <input name="admin" type="text" class="input">
</li>
<li>
管理员密码<span class="care">(不小于6位)</span><br />
<input name="adminpw" type="password" class="input">
</li>
<li>
再次输入管理员密码:<br />
<input name="adminpw2" type="password" class="input">
</li>
</div>
<div>
<p class="foot">
<input name="Submit" type="submit" class="submit" value="确 定">
<input name="Submit2" type="reset" class="submit" value="重 置">
</p>
</div>
<div>
<p class="foot">
&copy;2007 emlog
</p>
</div>
</div>
</form>
</body>
</html>
<?php
}

if(isset($_GET['action'])&&$_GET['action'] == "install"){

// 获取表单信息，修改配置文件
	$db_host = addslashes(trim($_POST['hostname']));//服务器地址
	$db_user = addslashes(trim($_POST['dbuser']));	 //mysql 数据库用户名
	$db_pw = addslashes(trim($_POST['password']));//mysql 数据库密码
	$db_name = addslashes(trim($_POST['dbname']));//数据库名
	$db_prefix = addslashes(trim($_POST['dbprefix']));//数据库前缀
	$admin = addslashes(trim($_POST['admin']));//管理员名
	$adminpw = addslashes(trim($_POST['adminpw']));//管理员密码
	$adminpw2 = addslashes(trim($_POST['adminpw2']));//管理员密码确认
	$result = '';

//错误返回函数
	if(empty($db_prefix)){
		sysMsg('数据库前缀不能为空!');
	}
	elseif(!ereg("^[a-zA-Z0-9_]+_$",$db_prefix)){
		sysMsg('数据库前缀格式错误!');
	}
	elseif($admin=="" || $adminpw==""){
		sysMsg('管理员和管理员密码不能为空!');
	}
	elseif(strlen($adminpw) < 6){
		sysMsg('管理员密码不得小于6位');
	}
	elseif($adminpw!=$adminpw2)	 {
		sysMsg('两次输入的密码不一致');
	}
@$fp = fopen("config.php", 'w') OR die("<table width=\"600\" align=\"center\" bgcolor=\"#f6f6f6\"><tr><td>打开配置文件(config.php)失败!检查文件权限</td></tr></table>");

	$config = "<?php\n"
				."//Emlog mysql config file"
				."\n\n//mysql database address\n"
				."\$host\t= "
				."'".$db_host."';"
				."\n\n//mysql database user\n"
				."\$user\t= "
				."'".$db_user."';"
				."\n\n//database password\n"
				."\$pass\t= "
				."'".$db_pw."';"
				."\n\n//database name\n"
				."\$db\t= "
				."'".$db_name."';"
				."\n\n//database prefix\n"
				."\$db_prefix\t= "
				."'".$db_prefix."';"
				."\n\n?>";

@$fw = fwrite($fp, $config) ;
	if (!$fw)
	{
 		sysMsg('抱歉！配置文件(config.php)修改失败!请检查该文件是否可写');
	}
	else
	{
		$result.="配置文件修改成功<br />";
	}
fclose($fp);

//初始化数据库类
$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);

$MC = new mkcache($db_host, $db_user, $db_pw,$db_name,$db_prefix);
unset($db_host, $db_user, $db_pw,$db_name);

$dbcharset = 'utf8';
$type = 'MYISAM';
$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
$extra2 = "TYPE=".$type;
$DB->version() > '4.1' ? $add = $extra:$add = $extra2.";";

//sql language
$sql = " 
DROP TABLE IF EXISTS ".$db_prefix."blog;
CREATE TABLE ".$db_prefix."blog (
  gid mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  date varchar(10) NOT NULL default '',
  content text NOT NULL,
  views mediumint(8) unsigned NOT NULL default '0',
  comnum mediumint(8) unsigned NOT NULL default '0',
  tbcount mediumint(8) unsigned NOT NULL default '0',
  top enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  allow_remark enum('n','y') NOT NULL default 'y',
  allow_tb enum('n','y') NOT NULL default 'y',
  attcache text NOT NULL,
  PRIMARY KEY  (gid)
)".$add."
INSERT INTO ".$db_prefix."blog (gid,title,date,content,views,comnum,tbcount,top,hide, allow_remark,allow_tb,attcache) VALUES (1, 'Hello Blogger', '1185702222', '感谢使用emlog,这是系统的默认日志,你可以删除它!', 0, 0, 0, 'n', 'n', 'y', 'y','');
DROP TABLE IF EXISTS ".$db_prefix."attachment;
CREATE TABLE ".$db_prefix."attachment (
  aid smallint(5) unsigned NOT NULL auto_increment,
  blogid mediumint(8) unsigned NOT NULL default '0',
  attdes varchar(255) NOT NULL default '',
  filename varchar(255) NOT NULL default '',
  filesize int(10) NOT NULL default '0',
  filepath varchar(255) NOT NULL default '',
  addtime varchar(10) NOT NULL default '',
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)".$add."
DROP TABLE IF EXISTS ".$db_prefix."comment;
CREATE TABLE ".$db_prefix."comment (
  cid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  date varchar(10) NOT NULL default '',
  poster varchar(20) NOT NULL default '',
  comment text NOT NULL,
  mail varchar(60) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (cid),
  KEY gid (gid)
)".$add."
DROP TABLE IF EXISTS ".$db_prefix."config;
CREATE TABLE ".$db_prefix."config (
  site_key varchar(255) NOT NULL default '',
  blogname varchar(255) NOT NULL default '',
  bloginfo varchar(255) NOT NULL default '',
  blogurl varchar(255) NOT NULL default '',
  icp varchar(255) NOT NULL default '',
  index_lognum tinyint(3) unsigned NOT NULL default '0',
  index_comnum tinyint(3) unsigned NOT NULL default '0',
  index_tagnum tinyint(3) unsigned NOT NULL default '1',
  comment_subnum tinyint(3) unsigned NOT NULL default '0',
  login_code enum('n','y') NOT NULL default 'n',
  comment_code enum('n','y') NOT NULL default 'n',
  iscomment enum('n','y') NOT NULL default 'n',
  isurlrewrite enum('n','y') NOT NULL default 'n',
  nonce_templet varchar(255) NOT NULL default '',
  timezone float NOT NULL default '8',
  exarea text NOT NULL
)".$add."
INSERT INTO ".$db_prefix."config (site_key, blogname, bloginfo, blogurl, icp, index_lognum, index_comnum, index_tagnum, comment_subnum, login_code, comment_code,iscomment, nonce_templet,timezone,exarea) VALUES ('Emlog', 'Emlog', 'welcome', 'http://', '', 10, 10,30, 20, 'n', 'n','n','default', 8 ,'');
DROP TABLE IF EXISTS ".$db_prefix."link;
CREATE TABLE ".$db_prefix."link (
  id smallint(4) unsigned NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  siteurl varchar(75) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  taxis smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO ".$db_prefix."link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog', 'http://www.emlog.net', 'emlog官方主页', 0);
DROP TABLE IF EXISTS ".$db_prefix."statistics;
CREATE TABLE ".$db_prefix."statistics (
  day_view_count int(11) unsigned NOT NULL default '0',
  view_count int(11) unsigned default '0',
  curdate varchar(20) default NULL
)".$add."
INSERT INTO ".$db_prefix."statistics (day_view_count, view_count, curdate) VALUES (0, 0, '2006-10-13');
DROP TABLE IF EXISTS ".$db_prefix."tag;
CREATE TABLE ".$db_prefix."tag (
  tid mediumint(8) unsigned NOT NULL auto_increment,
  tagname varchar(60) NOT NULL default '',
  usenum mediumint(8) unsigned NOT NULL default '1',
  gid text NOT NULL,
  PRIMARY KEY  (tid),
  KEY tagbame (tagname)
)".$add."
INSERT INTO ".$db_prefix."tag (tid, tagname, usenum,gid) VALUES (1, 'emlog', 1, ',1,');
DROP TABLE IF EXISTS ".$db_prefix."trackback;
CREATE TABLE ".$db_prefix."trackback (
  tbid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  date varchar(10) NOT NULL default '',
  excerpt text NOT NULL,
  url varchar(255) NOT NULL default '',
  blog_name varchar(255) NOT NULL default '',
  PRIMARY KEY  (tbid),
  KEY gid (gid)
)".$add."
DROP TABLE IF EXISTS ".$db_prefix."user;
CREATE TABLE ".$db_prefix."user (
  uid tinyint(3) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  nickname varchar(20) NOT NULL default '',
  photo varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  description varchar(255) NOT NULL default '',
PRIMARY KEY  (uid)
)".$add."
INSERT INTO ".$db_prefix."user (uid, username, password, photo, description) VALUES (1,'$admin','".md5($adminpw)."', '../images/blogger.gif','welcome to emlog!'); ";
	
    $mysql_query = explode(";",$sql);
    while (list(,$query) = each($mysql_query)) {
           $query = trim($query);
           if ($query) {
               if (strstr($query,'CREATE TABLE')) 
               {
                   ereg('CREATE TABLE ([^ ]*)',$query,$regs);
				   $result .= "数据库表: ".$regs[1]." 创建";
				   $ret = $DB->query($query);
					if (!$ret){
						$result .= "<b>失败！</b>，安装无法顺利完成，请检查该mysql用户是否有权限创建表\n";
						exit($result);
					} else {
						$result .= "成功...<br />\n";
					}
               } else {
                   $ret = $DB->query($query);
                   if (!$ret){
						$result .= "<b>抱歉！</b>如下sql语句运行错误，安装无法顺利完成<br />$query";
						exit($result);
					}
               }
			}
    }
	//重建缓存	
	//$MC->mc_blogger('./cache/blogger');//开启后头像会不显示
	$MC->mc_config('./cache/config');
	$MC->mc_record('./cache/records');
	$MC->mc_comment('./cache/comments');
	$MC->mc_logtags('./cache/log_tags');
	$MC->mc_logatts('./cache/log_atts');
	$MC->mc_sta('./cache/sta');
	$MC->mc_link('./cache/links');
	$MC->mc_tags('./cache/tags');

	$result .= "管理员:".$admin." 添加成功<br />恭喜你！Emlog安装成功，<b>请删除该安装文件</b> <a href=\"./index.php\">进入Emlog </a>";
	sysMsg($result);
}
?>