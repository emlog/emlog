<?php
/**
 * Install
 * @package EMLOG (www.emlog.net)
 */

/*vot*/ define('EMLOG_ROOT', str_replace('\\','/',__DIR__));
const DEL_INSTALLER = 0;

require_once EMLOG_ROOT . '/include/lib/function.base.php';

/*vot*/ define('EMLOG_LANGUAGE','en'); //sc, tc, en, ru, etc.
/*vot*/ define('EMLOG_LANGUAGE_DIR','ltr'); //ltr, rtl 

/*vot*/ load_language('core');
/*vot*/ load_language('install');

header('Content-Type: text/html; charset=UTF-8');
spl_autoload_register("emAutoload");

if (PHP_VERSION < '7.0') {
/*vot*/    emMsg(lang('php_required'));
}

$act = isset($_GET['action']) ? $_GET['action'] : '';

if (!$act) {
?>
<!doctype html>
<!--vot--><html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?= EMLOG_LANGUAGE ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>emlog</title>
        <style type="text/css">
            <!--
            body {
                background-color: #F7F7F7;
                font-family: Arial;
                font-size: 12px;
                line-height: 150%;
            }

            .main {
                background-color: #FFFFFF;
                font-size: 12px;
                color: #666666;
                width: 750px;
                margin: 30px auto;
                padding: 50px;
                list-style: none;
                border: #DFDFDF 1px solid;
                border-radius: 4px;
            }

            .logo {
                background: url(admin/views/images/logo.gif) no-repeat center;
                padding: 30px 0px 30px 0px;
                margin: 30px 0px;
            }

            .title {
                text-align: center;
                font-size: 14px;
            }

            .input {
                border: 1px solid #CCCCCC;
                font-family: Arial;
                font-size: 18px;
                height: 28px;
                background-color: #F7F7F7;
                color: #666666;
                margin: 0px 0px 0px 25px;
            }

            .submit {
                cursor: pointer;
                font-size: 12px;
                padding: 4px 10px;
            }

            .care {
                color: #0066CC;
            }

            .title2 {
                font-size: 18px;
                color: #666666;
                border-bottom: #CCCCCC 1px solid;
                margin: 40px 0px 20px 0px;
                padding: 10px 0px;
            }

            .foot {
                text-align: center;
            }

            .main li {
                margin: 20px 0px;
            }

            -->
        </style>
</head>
<body>
    <form name="form1" method="post" action="install.php?action=install">
        <div class="main">
            <p class="logo"></p>
<!--vot-->  <p class="title">emlog <?php echo Option::EMLOG_VERSION ?></p>
            <div class="b">
<!--vot-->      <p class="title2"><?= lang('mysql_settings') ?></p>
                <li>
<!--vot-->          <?= lang('db_hostname') ?>:<br>
                    <input name="hostname" type="text" class="input" value="127.0.0.1">
<!--vot-->          <span class="care"><?= lang('db_hostname_info') ?></span>
                </li>
                <li>
<!--vot-->          <?= lang('db_user') ?>:<br><input name="dbuser" type="text" class="input" value="">
                </li>
                <li>
<!--vot-->          <?= lang('db_password') ?>:<br><input name="password" type="password" class="input">
                </li>
                <li>
<!--vot-->          <?= lang('db_name') ?>:<br>
                    <input name="dbname" type="text" class="input" value="">
<!--vot-->          <span class="care"><?= lang('db_name_info') ?></span>
                </li>
                <li>
<!--vot-->          <?= lang('db_prefix') ?>:<br>
                    <input name="dbprefix" type="text" class="input" value="emlog_">
<!--vot-->          <span class="care"><?= lang('db_prefix_info') ?></span>
                </li>
            </div>
            <div class="c">
<!--vot-->      <p class="title2"><?= lang('admin_settings') ?></p>
                <li>
<!--vot-->          <?= lang('admin_name') ?>:<br>
                    <input name="admin" type="text" class="input">
                </li>
                <li>
<!--vot-->          <?= lang('admin_password') ?>:<br>
                    <input name="adminpw" type="password" class="input">
<!--vot-->          <span class="care"><?= lang('admin_password_info') ?></span>
                </li>
                <li>
<!--vot-->          <?= lang('admin_password_repeat') ?>:<br>
                    <input name="adminpw2" type="password" class="input">
                </li>
            </div>
            <div>
<!--vot-->      <p class="foot"><input type="submit" class="submit" value=<?= lang('install_emlog') ?>"></p>
            </div>
        </div>
    </form>
    </body>
    </html>
	<?php
}
if ($act == 'install' || $act == 'reinstall') {
	$db_host = isset($_POST['hostname']) ? addslashes(trim($_POST['hostname'])) : '';
	$db_user = isset($_POST['dbuser']) ? addslashes(trim($_POST['dbuser'])) : '';
	$db_pw = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$db_name = isset($_POST['dbname']) ? addslashes(trim($_POST['dbname'])) : '';
	$db_prefix = isset($_POST['dbprefix']) ? addslashes(trim($_POST['dbprefix'])) : '';
	$admin = isset($_POST['admin']) ? addslashes(trim($_POST['admin'])) : '';
	$adminpw = isset($_POST['adminpw']) ? addslashes(trim($_POST['adminpw'])) : '';
	$adminpw2 = isset($_POST['adminpw2']) ? addslashes(trim($_POST['adminpw2'])) : '';
	$result = '';

	if ($db_prefix == '') {
/*vot*/        emMsg(lang('db_prefix_empty'));
	} elseif (!preg_match("/^[\w_]+_$/", $db_prefix)) {
/*vot*/        emMsg(lang('db_prefix_empty'));
	} elseif ($admin == '' || $adminpw == '') {
/*vot*/        emMsg(lang('username_password_empty'));
/*vot*/    } elseif (strlen($adminpw) < 5) {
/*vot*/        emMsg(lang('password_short'));
	} elseif ($adminpw != $adminpw2) {
/*vot*/        emMsg(lang('password_not_equal'));
	}

	//Initialize the database class
	define('DB_HOST', $db_host);
	define('DB_USER', $db_user);
	define('DB_PASSWD', $db_pw);
	define('DB_NAME', $db_name);
	define('DB_PREFIX', $db_prefix);

	$DB = Database::getInstance();
	$CACHE = Cache::getInstance();

	if ($DB->getMysqlVersion() < '5.5.3') {
/*vot*/ emMsg(lang('mysql_required'));
	}

	if ($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1) {
/*vot*/ echo <<<EOT
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
<!--vot--><input name="hostname" type="hidden" class="input" value="<?=$db_host?>">
<!--vot--><input name="dbuser" type="hidden" class="input" value="<?=$db_user?>">
<!--vot--><input name="password" type="hidden" class="input" value="<?=$db_pw?>">
<!--vot--><input name="dbname" type="hidden" class="input" value="<?=$db_name?>">
<!--vot--><input name="dbprefix" type="hidden" class="input" value="<?=$db_prefix?>">
<!--vot--><input name="admin" type="hidden" class="input" value="<?=$admin?>">
<!--vot--><input name="adminpw" type="hidden" class="input" value="<?=$adminpw?>">
<!--vot--><input name="adminpw2" type="hidden" class="input" value="<?=$adminpw2?>">
<p>
<!--vot--><?=lang('already_installed')?>
<!--vot--><input type="submit" value="<?=lang('continue')?>">
</p>
<!--vot--><p><a href="javascript:history.back(-1);"><?=lang('return')?></a></p>
</div>
</form>
</body>
</html>
EOT;
		exit;
	}

    // Create config.php
/*vot*/    if ( $fp = @fopen('config.php', 'w') ){
/*vot*/        fclose($fp);
/*vot*/    }

	if (!is_writable('config.php')) {
/*vot*/        emMsg(lang('config_not_writable'));
	}
	if (!is_writable(EMLOG_ROOT . '/content/cache')) {
/*vot*/        emMsg(lang('cache_not_writable'));
	}
	$config = "<?php\n"
		. "//mysql database address\n"
		. "define('DB_HOST','$db_host');"
		. "\n//mysql database user\n"
		. "define('DB_USER','$db_user');"
		. "\n//database password\n"
		. "define('DB_PASSWD','$db_pw');"
		. "\n//database name\n"
		. "define('DB_NAME','$db_name');"
		. "\n//database prefix\n"
		. "define('DB_PREFIX','$db_prefix');"
		. "\n//auth key\n"
		. "define('AUTH_KEY','" . getRandStr(32) . md5($_SERVER['HTTP_USER_AGENT']) . "');"
		. "\n//cookie name\n"
		. "define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_" . getRandStr(32, false) . "');"
/*vot*/ . "//blog language\n"
/*vot*/ . "\ndefine('EMLOG_"."LANGUAGE','".EMLOG_LANGUAGE."'); //sc, tc, en, ru, etc."
/*vot*/ . "\n//blog language direction //vot\n"
/*vot*/ . "define('EMLOG_"."LANGUAGE_DIR','".EMLOG_LANGUAGE_DIR."'); //ltr, rtl"
		. "\n";

	$fp = @fopen('config.php', 'w');
	$fw = @fwrite($fp, $config);
	if (!$fw) {
/*vot*/        emMsg(lang('config_not_writable'));
	}
	fclose($fp);

    //Encrypt Password
	$PHPASS = new PasswordHash(8, true);
	$adminpw = $PHPASS->HashPassword($adminpw);

	$table_charset_sql = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
	$DB->query("ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;", true);

	$widgets = Option::getWidgetTitle();
	$sider_wg = Option::getDefWidget();

	$widget_title = serialize($widgets);
	$widgets = serialize($sider_wg);

	define('BLOG_URL', realUrl());

/*vot*/    $sql = "
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid int(11) unsigned NOT NULL auto_increment COMMENT 'Article table',
  title varchar(255) NOT NULL default '' COMMENT 'Article title',
  date bigint(20) NOT NULL COMMENT 'Publish time',
  content longtext NOT NULL  COMMENT 'Article content',
  excerpt longtext NOT NULL  COMMENT 'Article Summary',
  alias VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Article alias',
  author int(11) NOT NULL default '1' COMMENT 'Author',
  sortid int(11) NOT NULL default '-1' COMMENT 'Category ID',
  type varchar(64) NOT NULL default 'blog' COMMENT 'Article OR page',
  views int(11) unsigned NOT NULL default '0' COMMENT 'Read counter',
  comnum int(11) unsigned NOT NULL default '0' COMMENT 'Number of comments',
  attnum int(11) unsigned NOT NULL default '0' COMMENT 'Number of attachments',
  top enum('n','y') NOT NULL default 'n' COMMENT 'Top',
  sortop enum('n','y') NOT NULL default 'n' COMMENT 'Top category',
  hide enum('n','y') NOT NULL default 'n' COMMENT 'Draft=y',
  checked enum('n','y') NOT NULL default 'y' COMMENT 'If article is reviewed',
  allow_remark enum('n','y') NOT NULL default 'y' COMMENT 'Allow comments=y',
  password varchar(255) NOT NULL default '' COMMENT 'Access password',
  template varchar(255) NOT NULL default '' COMMENT 'Template',
  tags text COMMENT 'Tags',
  PRIMARY KEY (gid),
  KEY author (author),
  KEY views (views),
  KEY comnum (comnum),
  KEY sortid (sortid),
  KEY top (top,date)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,author,views,comnum,attnum,top,sortop,hide,allow_remark,password) VALUES (1, '" . lang('emlog_welcome') . "', '" . time() . "', '" . lang('emlog_install_congratulation') . "', '', 1, 0, 0, 0, 'n', 'n', 'n', 'y', '');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid int(11) unsigned NOT NULL auto_increment COMMENT 'Resource file table',
  blogid int(11) unsigned NOT NULL default '0' COMMENT 'Post ID',
  filename varchar(255) NOT NULL default '' COMMENT 'File name',
  filesize int(11) NOT NULL default '0' COMMENT 'File size',
  filepath varchar(255) NOT NULL default '' COMMENT 'File path',
  addtime bigint(20) NOT NULL default '0' COMMENT 'Creation time',
  width int(11) NOT NULL default '0' COMMENT 'Image width',
  height int(11) NOT NULL default '0' COMMENT 'Image Height',
  mimetype varchar(64) NOT NULL default '' COMMENT 'File mime type',
  thumfor int(11) NOT NULL default 0 COMMENT 'Thumbnail for original resource ID',
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid int(11) unsigned NOT NULL auto_increment COMMENT 'Comment ID',
  gid int(11) unsigned NOT NULL default '0' COMMENT 'Article ID',
  pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent comment ID',
  date bigint(20) NOT NULL COMMENT 'Creation time',
  poster varchar(255) NOT NULL default '' COMMENT 'Publisher',
  comment text NOT NULL COMMENT 'Comment content',
  mail varchar(255) NOT NULL default '' COMMENT 'Email',
  url varchar(255) NOT NULL default '' COMMENT 'Homepage URL',
  ip varchar(128) NOT NULL default '' COMMENT 'IP address',
  hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
  PRIMARY KEY  (cid),
  KEY gid (gid),
  KEY date (date),
  KEY hide (hide)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment COMMENT 'Cofiguration table',
option_name VARCHAR( 255 ) NOT NULL COMMENT 'Option name',
option_value LONGTEXT NOT NULL COMMENT 'Option value',
PRIMARY KEY (option_id),
UNIQUE KEY `option_name_uindex` (`option_name`)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','EMLOG');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','" . lang('emlog_powered') . "');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_title','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_description','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('log_title_style','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','" . BLOG_URL . "');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('footer_info','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_perpage_num','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_num','10');
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
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isexcerpt','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('excerpt_subnum','300');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','UTC');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_widget','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('detect_url','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('emkey','');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id int(11) unsigned NOT NULL auto_increment COMMENT 'Link table',
  sitename varchar(255) NOT NULL default '' COMMENT 'Name',
  siteurl varchar(255) NOT NULL default '' COMMENT 'URL',
  description varchar(255) NOT NULL default '' COMMENT 'Description',
  hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
  taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
  PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog.net', 'http://www.emlog.net', '" . lang('emlog_official_site') . "', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
  id int(11) unsigned NOT NULL auto_increment COMMENT 'Navigation table',
  naviname varchar(255) NOT NULL default '' COMMENT 'Navigation name',
  url varchar(512) NOT NULL default '' COMMENT 'Navigation URL',
  newtab enum('n','y') NOT NULL default 'n' COMMENT 'Open in a new window',
  hide enum('n','y') NOT NULL default 'n' COMMENT 'Hide or not',
  taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
  pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent ID',
  isdefault enum('n','y') NOT NULL default 'n' COMMENT 'Is the system default navigation, i.e. home page',
  type tinyint(3) unsigned NOT NULL default '0' COMMENT 'Navigation type: 0=custom, 1=home, 2=chat, 3=AdminCP, 4=Categories, 5=page',
  type_id int(11) unsigned NOT NULL default '0' COMMENT 'Navigation type corresponding ID',
  PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, '" . lang('home') . "', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, '" . lang('login') . "', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid int(11) unsigned NOT NULL auto_increment COMMENT 'Label table',
  tagname varchar(255) NOT NULL default '' COMMENT 'Tag name',
  gid text NOT NULL COMMENT 'Article ID',
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid int(11) unsigned NOT NULL auto_increment COMMENT 'Category Table',
  sortname varchar(255) NOT NULL default '' COMMENT 'Category name',
  alias VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Alias',
  taxis int(11) unsigned NOT NULL default '0' COMMENT 'Sort order',
  pid int(11) unsigned NOT NULL default '0' COMMENT 'Parent category ID',
  description text NOT NULL COMMENT 'Description',
  template varchar(255) NOT NULL default '' COMMENT 'Category template',
  PRIMARY KEY  (sid)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid int(11) unsigned NOT NULL auto_increment COMMENT 'User table',
  username varchar(255) NOT NULL default '' COMMENT 'User name',
  password varchar(255) NOT NULL default '' COMMENT 'User password',
  nickname varchar(255) NOT NULL default '' COMMENT 'Nickname',
  role varchar(255) NOT NULL default '' COMMENT 'Role',
  ischeck enum('n','y') NOT NULL default 'n' COMMENT 'Need to preview  by admin',
  photo varchar(255) NOT NULL default '' COMMENT 'Avatar',
  email varchar(255) NOT NULL default '' COMMENT 'Email',
  description varchar(255) NOT NULL default '' COMMENT 'Description',
PRIMARY KEY  (uid),
KEY username (username)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}user (uid, username, password, role) VALUES (1,'$admin','" . $adminpw . "','admin');
DROP TABLE IF EXISTS {$db_prefix}storage;
CREATE TABLE {$db_prefix}storage (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Object storage table',
  `plugin` varchar(64) NOT NULL COMMENT 'Plugin name',
  `name` varchar(255) NOT NULL COMMENT 'Object name',
  `type` varchar(32) NOT NULL COMMENT 'Object data type',
  `value` text NOT NULL COMMENT 'Object value',
  `createdate` int(11) NOT NULL COMMENT 'Create time',
  `lastupdate` int(11) NOT NULL COMMENT 'Update time',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `plugin` (`plugin`,`name`)
)" . $table_charset_sql;

	$array_sql = preg_split("/;[\r\n]/", $sql);
	foreach ($array_sql as $sql) {
		$sql = trim($sql);
		if ($sql) {
			$DB->query($sql);
		}
	}
    //Rebuild cache
	$CACHE->updateCache();
/*vot*/    $result .= "
        <p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">".lang('emlog_installed')."</p>
        <p>" . lang('emlog_installed_info') . "</p>
        <p><b>" . lang('user_name') . "</b>: {$admin}</p>
        <p><b>" . lang('password')."</b>: " . lang('password_entered') . "</p>";
	if ((DEL_INSTALLER === 1 && !@unlink('./install.php')) || DEL_INSTALLER === 0) {
/*vot*/        $result .= '<p style="color:#ff0000;margin:10px 20px;">' . lang('delete_install') . '</p> ';
	}
/*vot*/    $result .= "<p style=\"text-align:right;\"><a href=\"./\">" . lang('go_to_front') . "</a> | <a href=\"./admin/\">" . lang('go_to_admincp') . "</a></p>";
	emMsg($result, 'none');
}
