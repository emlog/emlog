<?php
/**
 * Install
 * @copyright (c) Emlog All Rights Reserved
 */

/*vot*/ define('EMLOG_ROOT', str_replace('\\','/',dirname(__FILE__)));
/*vot*/ define('DEL_INSTALLER', 0);

require_once EMLOG_ROOT.'/include/lib/function.base.php';

//Blog language //vot
//define('EMLOG_LANGUAGE','zh-CN');
//define('EMLOG_LANGUAGE','zh-TW');
define('EMLOG_LANGUAGE','en');
//define('EMLOG_LANGUAGE','ru');
/*vot*/ load_language('install');

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();

$act = isset($_GET['action'])? $_GET['action'] : '';

if (PHP_VERSION < '5.0'){
/*vot*/    emMsg(lang('php5_required'));
}

if(!$act){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--vot--><html xmlns="http://www.w3.org/1999/xhtml" lang="<?= EMLOG_LANGUAGE ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>emlog</title>
<style type="text/css">
<!--
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:30px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid; border-radius: 4px;}
.logo{background:url(admin/views/images/logo.gif) no-repeat center;padding:30px 0px 30px 0px;margin:30px 0px;}
.title{text-align:center; font-size: 14px;}
.input {border: 1px solid #CCCCCC;font-family: Arial;font-size: 18px;height:28px;background-color:#F7F7F7;color: #666666;margin:0px 0px 0px 25px;}
.submit{cursor: pointer;font-size: 12px;padding: 4px 10px;}
.care{color:#0066CC;}
.title2{font-size:18px;color:#666666;border-bottom: #CCCCCC 1px solid; margin:40px 0px 20px 0px;padding:10px 0px;}
.foot{text-align:center;}
.main li{ margin:20px 0px;}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="install.php?action=install">
<div class="main">
<p class="logo"></p>
<!--vot--><p class="title">emlog <?php echo Option::EMLOG_VERSION ?> <?= lang('install')?></p>
<div class="b">
<!--vot--><p class="title2"><?= lang('mysql_settings')?></p>
<li>
<!--vot--> <?= lang('db_hostname')?>:<br />
    <input name="hostname" type="text" class="input" value="localhost">
<!--vot--> <span class="care"><?= lang('db_hostname_info')?></span>
</li>
<li>
<!--vot--> <?= lang('db_user')?>:<br /><input name="dbuser" type="text" class="input" value="">
</li>
<li>
<!--vot--> <?= lang('db_password')?>:<br /><input name="password" type="password" class="input">
</li>
<li>
<!--vot--> <?= lang('db_name')?>:<br />
      <input name="dbname" type="text" class="input" value="">
<!--vot--> <span class="care"><?= lang('db_name_info')?></span>
</li>
<li>
<!--vot--> <?= lang('db_prefix')?>:<br />
  <input name="dbprefix" type="text" class="input" value="emlog_">
<!--vot--> <span class="care"><?= lang('db_prefix_info')?></span>
</li>
</div>
<div class="c">
<!--vot--><p class="title2"><?= lang('admin_settings')?></p>
<li>
<!--vot--> <?= lang('admin_name')?>:<br />
<input name="admin" type="text" class="input">
</li>
<li>
<!--vot--><?= lang('admin_password')?>:<br />
<input name="adminpw" type="password" class="input">
<!--vot--><span class="care"><?= lang('admin_password_info')?></span>
</li>
<li>
<!--vot--><?= lang('admin_password_repeat')?>:<br />
<input name="adminpw2" type="password" class="input">
</li>
</div>
<div>
<p class="foot">
<!--vot--><input type="submit" class="submit" value="<?= lang('install_emlog')?>">
</p>
</div>
</div>
</form>
</body>
</html>
<?php
}
if($act == 'install' || $act == 'reinstall'){
	$db_host = isset($_POST['hostname']) ? addslashes(trim($_POST['hostname'])) : '';
	$db_user = isset($_POST['dbuser']) ? addslashes(trim($_POST['dbuser'])) : '';
	$db_pw = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$db_name = isset($_POST['dbname']) ? addslashes(trim($_POST['dbname'])) : '';
	$db_prefix = isset($_POST['dbprefix']) ? addslashes(trim($_POST['dbprefix'])) : '';
	$admin = isset($_POST['admin']) ? addslashes(trim($_POST['admin'])) : '';
	$adminpw = isset($_POST['adminpw']) ? addslashes(trim($_POST['adminpw'])) : '';
	$adminpw2 = isset($_POST['adminpw2']) ? addslashes(trim($_POST['adminpw2'])) : '';
	$result = '';

	if($db_prefix == ''){
/*vot*/		emMsg(lang('db_prefix_empty'));
	}elseif(!preg_match("/^[\w_]+_$/",$db_prefix)){
/*vot*/		emMsg(lang('db_prefix_empty'));
	}elseif($admin == '' || $adminpw == ''){
/*vot*/		emMsg(lang('username_password_empty'));
/*vot*/	}elseif(mb_strlen($adminpw) < 5){
/*vot*/		emMsg(lang('password_short'));
	}elseif($adminpw!=$adminpw2)	 {
/*vot*/		emMsg(lang('password_not_equal'));
	}

	//Initialize the database class
	define('DB_HOST',   $db_host);
	define('DB_USER',   $db_user);
	define('DB_PASSWD', $db_pw);
	define('DB_NAME',   $db_name);
	define('DB_PREFIX', $db_prefix);

	$DB = Database::getInstance();
	$CACHE = Cache::getInstance();

	if($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1){
		echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog system message</title>
<style type="text/css">
<!--
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:10px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid;}
.main p {line-height: 18px;margin: 5px 20px;}
-->
</style>
</head><body>
<form name="form1" method="post" action="install.php?action=reinstall">
<div class="main">
	<input name="hostname" type="hidden" class="input" value="$db_host">
	<input name="dbuser" type="hidden" class="input" value="$db_user">
	<input name="password" type="hidden" class="input" value="$db_pw">
	<input name="dbname" type="hidden" class="input" value="$db_name">
	<input name="dbprefix" type="hidden" class="input" value="$db_prefix">
	<input name="admin" type="hidden" class="input" value="$admin">
	<input name="adminpw" type="hidden" class="input" value="$adminpw">
	<input name="adminpw2" type="hidden" class="input" value="$adminpw2">
<p>
<!--vot-->{lang('already_installed')}
<!--vot--><input type="submit" value="{lang('continue')}">
</p>
<!--vot--><p><a href="javascript:history.back(-1);">{lang('return')}</a></p>
</div>
</form>
</body>
</html>
EOT;
		exit;
	}

	if(!is_writable('config.php')){
/*vot*/		emMsg(lang('config_not_writable'));
	}
	if(!is_writable(EMLOG_ROOT.'/content/cache')){
/*vot*/		emMsg(lang('cache_not_writable'));
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
/*vot*/	."\n//blog language //vot\n"
/*vot*/	."define('EMLOG_"."LANGUAGE','".EMLOG_LANGUAGE."');"
	."\n";

	$fp = @fopen('config.php', 'w');
	$fw = @fwrite($fp, $config);
	if (!$fw){
/*vot*/		emMsg(lang('config_not_writable'));
	}
	fclose($fp);

	//Encrypt Password
	$PHPASS = new PasswordHash(8, true);
	$adminpw = $PHPASS->HashPassword($adminpw);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $DB->getMysqlVersion() > '4.1' ? 'ENGINE='.$type.' DEFAULT CHARSET='.$dbcharset.';':'TYPE='.$type.';';
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
    
    $widgets = Option::getWidgetTitle();
    $sider_wg = Option::getDefWidget();

	$widget_title = serialize($widgets);
	$widgets = serialize($sider_wg);

	define('BLOG_URL', getBlogUrl());

	$sql = $setchar."
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid int(10) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  date bigint(20) NOT NULL,
  content longtext NOT NULL,
  excerpt longtext NOT NULL,
  alias VARCHAR(200) NOT NULL DEFAULT '',
  author int(10) NOT NULL default '1',
  sortid int(10) NOT NULL default '-1',
  type varchar(20) NOT NULL default 'blog',
  views int(10) unsigned NOT NULL default '0',
  comnum int(10) unsigned NOT NULL default '0',
  attnum int(10) unsigned NOT NULL default '0',
  top enum('n','y') NOT NULL default 'n',
  sortop enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  checked enum('n','y') NOT NULL default 'y',
  allow_remark enum('n','y') NOT NULL default 'y',
  password varchar(255) NOT NULL default '',
  template varchar(255) NOT NULL default '',
  PRIMARY KEY  (gid),
  KEY date (date),
  KEY author (author),
  KEY sortid (sortid),
  KEY type (type),
  KEY views (views),
  KEY comnum (comnum),
  KEY hide (hide)
)".$add."
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,author,views,comnum,attnum,top,sortop,hide,allow_remark,password) VALUES (1, '".lang('emlog_welcome')."', '".time()."', '".lang('emlog_install_congratulation')."', '', 1, 0, 0, 0, 'n', 'n', 'n', 'y', '');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid int(10) unsigned NOT NULL auto_increment,
  blogid int(10) unsigned NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  filesize int(10) NOT NULL default '0',
  filepath varchar(255) NOT NULL default '',
  addtime bigint(20) NOT NULL default '0',
  width int(10) NOT NULL default '0',
  height int(10) NOT NULL default '0',
  mimetype varchar(40) NOT NULL default '',
  thumfor int(10) NOT NULL default 0,
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid int(10) unsigned NOT NULL auto_increment,
  gid int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  poster varchar(20) NOT NULL default '',
  comment text NOT NULL,
  mail varchar(60) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  ip varchar(128) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (cid),
  KEY gid (gid),
  KEY date (date),
  KEY hide (hide)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment,
option_name VARCHAR( 255 ) NOT NULL ,
option_value LONGTEXT NOT NULL ,
PRIMARY KEY (option_id),
KEY option_name (option_name)
)".$add."
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','".lang('my_blog')."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','".lang('emlog_powered')."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_title','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_description','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('log_title_style','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','".BLOG_URL."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('footer_info','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_perpage_num','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_num','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_fulltext','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_twnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newtwnum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_randlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_hotlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_subnum','20');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('nonce_templet','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_style','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('tpl_sidenum','1');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_needchinese','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_interval',60);
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgravatar','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isthumbnail','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_maxsize','20480');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_type','rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls,xlsx');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxh','460');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_paging','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_pnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_order','newer');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('reply_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('iscomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias_html','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgzipenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isxmlrpcenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ismobile','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isexcerpt','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('excerpt_subnum','300');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istwitter','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('topimg','content/templates/default/images/top/default.jpg');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_topimgs','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','8');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_widget','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets4','');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id int(10) unsigned NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  siteurl varchar(75) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  taxis int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog', 'http://www.emlog.net', '".lang('emlog_official_site')."', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
  id int(10) unsigned NOT NULL auto_increment,
  naviname varchar(30) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  newtab enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  taxis int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  isdefault enum('n','y') NOT NULL default 'n',
  type tinyint(3) unsigned NOT NULL default '0',
  type_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, '".lang('home')."', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (2, '".lang('twits')."', 't', 2, 'y', 2);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, '".lang('login')."', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid int(10) unsigned NOT NULL auto_increment,
  tagname varchar(60) NOT NULL default '',
  gid text NOT NULL,
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid int(10) unsigned NOT NULL auto_increment,
  sortname varchar(255) NOT NULL default '',
  alias VARCHAR(200) NOT NULL DEFAULT '',
  taxis int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  description text NOT NULL,
  template varchar(255) NOT NULL default '',
  PRIMARY KEY  (sid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT,
content text NOT NULL,
img varchar(200) DEFAULT NULL,
author int(10) NOT NULL default '1',
date bigint(20) NOT NULL,
replynum int(10) unsigned NOT NULL default '0',
PRIMARY KEY (id),
KEY author (author)
)".$add."
INSERT INTO {$db_prefix}twitter (id, content, img, author, date, replynum) VALUES (1, '".lang('test_tweet')."', '', 1, '".time()."', 0);
DROP TABLE IF EXISTS {$db_prefix}reply;
CREATE TABLE {$db_prefix}reply (
  id int(10) unsigned NOT NULL auto_increment,
  tid int(10) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  name varchar(20) NOT NULL default '',
  content text NOT NULL,
  hide enum('n','y') NOT NULL default 'n',
  ip varchar(128) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY gid (tid),
  KEY hide (hide)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid int(10) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(64) NOT NULL default '',
  nickname varchar(20) NOT NULL default '',
  role varchar(60) NOT NULL default '',
  ischeck enum('n','y') NOT NULL default 'n',
  photo varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  description varchar(255) NOT NULL default '',
PRIMARY KEY  (uid),
KEY username (username)
)".$add."
INSERT INTO {$db_prefix}user (uid, username, password, role) VALUES (1,'$admin','".$adminpw."','admin');";

	$array_sql = preg_split("/;[\r\n]/", $sql);
	foreach($array_sql as $sql){
		$sql = trim($sql);
		if ($sql){
			$DB->query($sql);
		}
	}
	//Rebuild cache
	$CACHE->updateCache();
/*vot*/	$result .= "
		<p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">".lang('emlog_installed')."</p>
		<p>".lang('emlog_installed_info')."</p>
		<p><b>".lang('user_name')."</b>: {$admin}</p>
		<p><b>".lang('password')."</b>: ".lang('password_entered')."</p>";
	if (DEL_INSTALLER === 1 && !@unlink('./install.php') || DEL_INSTALLER === 0) {
/*vot*/	    $result .= '<p style="color:red;margin:10px 20px;">'.lang('delete_install').'</p> ';
	}
/*vot*/	$result .= "<p style=\"text-align:right;\"><a href=\"./\">".lang('go_to_front')."</a> | <a href=\"./admin/\">".lang('go_to_admincp')."</a></p>";
	emMsg($result, 'none');
}
