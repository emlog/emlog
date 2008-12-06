<?php
/**
 * 安装程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./lib/F_base.php');
require_once('./lib/C_mysql.php');
require_once('./lib/C_cache.php');
require_once("./lib/C_phpass.php");

doStripslashes();

define('EMLOG_VERSION', '3.0.0');
define('EMLOG_ROOT', dirname(__FILE__));

if(!isset($_GET['action']))
{
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
<p><span class="title">emlog <?php echo EMLOG_VERSION ?></span><span> 安装程序</span></p>
</div>
<div class="a">
<p class="title2">1.权限设置</p>
Linux 系统请在执行安装程序之前设置如下文件或目录权限为777：(Win系统无需设置)<br>
./config.php（文件）<br>
./content/cache/（目录下所有文件）<br>
./content/uploadfile（目录）<br>
./content/backup（目录）<br>
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
    <span class="care"> (由英文字母、数字、下划线组成，且必须以下划线结束)</span><br />
  <input name="dbprefix" type="text" class="input" value="emlog_">
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
Powered by <a href="http://www.emlog.net">emlog</a>
</p>
</div>
</div>
</form>
</body>
</html>
<?php
}

if(isset($_GET['action']) && $_GET['action'] == "install")
{
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
	if(empty($db_prefix))
	{
		sysMsg('数据库前缀不能为空!');
	}elseif(!ereg("^[a-zA-Z0-9_]+_$",$db_prefix)){
		sysMsg('数据库前缀格式错误!');
	}elseif($admin=="" || $adminpw==""){
		sysMsg('管理员和管理员密码不能为空!');
	}elseif(strlen($adminpw) < 6){
		sysMsg('管理员密码不得小于6位');
	}elseif($adminpw!=$adminpw2)	 {
		sysMsg('两次输入的密码不一致');
	}
	@$fp = fopen("config.php", 'w') OR die("<table width=\"600\" align=\"center\" bgcolor=\"#f6f6f6\"><tr><td>打开配置文件(config.php)失败!检查文件权限</td></tr></table>");

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
		sysMsg('抱歉！配置文件(config.php)修改失败!请检查该文件是否可写');
	}else{
		$result.="配置文件修改成功<br />";
	}
	fclose($fp);

	//初始化数据库类
	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	$CACHE = new mkcache($DB, $db_prefix);
	//密码加密存储
	$PHPASS = new PasswordHash(8, true);
	$adminpw = $PHPASS->HashPassword($adminpw);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
	$setchar = $DB->getMysqlVersion() > '4.1'?"ALTER DATABASE {$db_name} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;":'';

	$widgets = array(
	'blogger'=>'EMER',
	'calendar'=>'日历',
	'tag'=>'标签',
	'sort'=>'分类',
	'archive'=>'存档',
	'newcomm'=>'最新评论',
	'twitter'=>'Twitter',
	'newlog'=>'最新日志',
	'random_log'=>'随机日志',
	'music'=>'音乐',
	'link'=>'链接',
	'search'=>'搜索',
	'bloginfo'=>'博客信息',
	'custom_text'=>'自定义栏目'
	);
	$wg = array();
	foreach ($widgets as $key=>$val)
	{
		$wg[] = $key;
	}
	$widget_title = serialize($widgets);
	$widgets = serialize($wg);

	//sql language
	$sql = $setchar."
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  date varchar(10) NOT NULL default '',
  content text NOT NULL,
  sortid tinyint(3) NOT NULL default '-1',
  views mediumint(8) unsigned NOT NULL default '0',
  comnum mediumint(8) unsigned NOT NULL default '0',
  tbcount mediumint(8) unsigned NOT NULL default '0',
  attnum mediumint(8) unsigned NOT NULL default '0',
  top enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  allow_remark enum('n','y') NOT NULL default 'y',
  allow_tb enum('n','y') NOT NULL default 'y',
  PRIMARY KEY  (gid)
)".$add."
INSERT INTO {$db_prefix}blog (gid,title,date,content,views,comnum,attnum,tbcount,top,hide, allow_remark,allow_tb) VALUES (1, 'Hello Blogger', '1204460230', '感谢使用emlog,这是系统的默认日志,你可以删除它!', 0, 0, 0, 0, 'n', 'n', 'y', 'y');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid smallint(5) unsigned NOT NULL auto_increment,
  blogid mediumint(8) unsigned NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  filesize int(10) NOT NULL default '0',
  filepath varchar(255) NOT NULL default '',
  addtime varchar(10) NOT NULL default '',
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  date varchar(10) NOT NULL default '',
  poster varchar(20) NOT NULL default '',
  comment text NOT NULL,
  reply text NOT NULL,
  mail varchar(60) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (cid),
  KEY gid (gid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment,
option_name VARCHAR( 255 ) NOT NULL ,
option_value LONGTEXT NOT NULL ,
PRIMARY KEY (option_id)
)".$add."
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','welcome');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','http://');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_twnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_randlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_subnum','20');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('nonce_templet','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('tpl_sidenum','1');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgzipenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istrackback','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','8');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('music','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title1','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content1','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets4','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title4','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content4','');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id smallint(4) unsigned NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  siteurl varchar(75) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  taxis smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog', 'http://www.emlog.net', 'emlog官方主页', 0);
DROP TABLE IF EXISTS {$db_prefix}statistics;
CREATE TABLE {$db_prefix}statistics (
  day_view_count int(11) unsigned NOT NULL default '0',
  view_count int(11) unsigned default '0',
  curdate varchar(20) default NULL
)".$add."
INSERT INTO {$db_prefix}statistics (day_view_count, view_count, curdate) VALUES (0, 0, '2006-10-13');
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid mediumint(8) unsigned NOT NULL auto_increment,
  tagname varchar(60) NOT NULL default '',
  usenum mediumint(8) unsigned NOT NULL default '1',
  gid text NOT NULL,
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)".$add."
INSERT INTO {$db_prefix}tag (tid, tagname, usenum,gid) VALUES (1, 'emlog', 1, ',1,');
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid tinyint(3) unsigned NOT NULL auto_increment,
  sortname varchar(255) NOT NULL default '',
  taxis tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (sid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}trackback;
CREATE TABLE {$db_prefix}trackback (
  tbid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  date varchar(10) NOT NULL default '',
  excerpt text NOT NULL,
  url varchar(255) NOT NULL default '',
  blog_name varchar(255) NOT NULL default '',
  ip varchar(16) NOT NULL default '',
  PRIMARY KEY  (tbid),
  KEY gid (gid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT ,
content VARCHAR(255) NOT NULL ,
date VARCHAR(10) NOT NULL ,
PRIMARY KEY (id)
)".$add."
INSERT INTO {$db_prefix}twitter (id,content, date) VALUES (1,'用简单的文字记录你的生活','1204460230');
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid tinyint(3) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(64) NOT NULL default '',
  nickname varchar(20) NOT NULL default '',
  photo varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  description text NOT NULL,
PRIMARY KEY  (uid)
)".$add."
INSERT INTO {$db_prefix}user (uid, username, password, photo, description) VALUES (1,'$admin','".$adminpw."', '','welcome to emlog!');";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			if (strstr($query,'CREATE TABLE'))
			{
				ereg('CREATE TABLE ([^ ]*)',$query,$regs);
				$result .= "数据库表: ".$regs[1]." 创建";
				$ret = $DB->query($query);
				if (!$ret)
				{
					$result .= "<b>失败！</b>，安装无法顺利完成，请检查该mysql用户是否有权限创建表\n";
					sysMsg($result);
				}else{
					$result .= "成功...<br />\n";
				}
			} else {
				$ret = $DB->query($query);
				if (!$ret)
				{
					$result .= "<b>抱歉！</b>如下sql语句运行错误，安装无法顺利完成<br />$query";
					sysMsg($result);
				}
			}
		}
	}
	//重建缓存
	$CACHE->mc_blogger();
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

	$result .= "管理员:".$admin." 添加成功<br />恭喜你！emlog 安装成功，<b>请删除该安装文件</b> <a href=\"./index.php\">进入emlog </a>";
	sysMsg($result);
}
?>