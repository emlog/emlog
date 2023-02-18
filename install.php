<?php
/**
 * install
 * @package EMLOG
 * @link https://www.emlog.net
 */

const EMLOG_ROOT = __DIR__;

require_once EMLOG_ROOT . '/include/lib/common.php';
header('Content-Type: text/html; charset=UTF-8');
spl_autoload_register("emAutoload");

if (PHP_VERSION < '5.6') {
	emMsg('PHP版本太低，请使用PHP5.6及以上版本(推荐7.4)');
}

$act = isset($_GET['action']) ? $_GET['action'] : '';

$bt_db_host = 'localhost';
$bt_db_username = 'BT_DB_USERNAME';
$bt_db_password = 'BT_DB_PASSWORD';
$bt_db_name = 'BT_DB_NAME';

$env_emlog_env = getenv('EMLOG_ENV');
$env_db_host = getenv('EMLOG_DB_HOST');
$env_db_name = getenv('EMLOG_DB_NAME');
$env_db_user = getenv('EMLOG_DB_USER');
$env_db_password = getenv('EMLOG_DB_PASSWORD');

if (!$act) {
	?>
    <!doctype html>
    <html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>emlog</title>
        <style>
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
                background: url(admin/views/images/logo.png) no-repeat center;
                padding: 50px 0px 50px 0px;
                margin: 0px 0px;
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

            .next_btn {
                margin: 50px 0px 10px 0px;
                text-align: center;
            }

            .footer {
                margin: 20px 0px 30px 0px;
                text-align: center;
            }

            .main li {
                margin: 40px 0px 20px 0px;
                margin: 20px 0px;
            }
        </style>
    </head>
    <body>
    <form name="form1" method="post" action="install.php?action=install">
        <div class="main">
            <p class="logo"></p>
            <p class="title">emlog <?php echo Option::EMLOG_VERSION ?></p>
			<?php if ($env_db_user): ?>
                <div class="b">
                    <input name="hostname" type="hidden" value="<?= $env_db_host ?>">
                    <input name="dbuser" type="hidden" value="<?= $env_db_user ?>">
                    <input name="dbpasswd" type="hidden" value="<?= $env_db_password ?>">
                    <input name="dbname" type="hidden" value="<?= $env_db_name ?>">
                    <input name="dbprefix" type="hidden" value="emlog_">
                </div>
			<?php elseif (strpos($bt_db_username, 'BT_DB_') === false): ?>
                <div class="b">
                    <input name="hostname" type="hidden" value="<?= $bt_db_host ?>">
                    <input name="dbuser" type="hidden" value="<?= $bt_db_username ?>">
                    <input name="dbpasswd" type="hidden" value="<?= $bt_db_password ?>">
                    <input name="dbname" type="hidden" value="<?= $bt_db_name ?>">
                    <input name="dbprefix" type="hidden" value="emlog_">
                </div>
			<?php else: ?>
                <div class="b">
                    <p class="title2">MySQL数据库设置</p>
                    <li>
                        数据库地址<br/>
                        <input name="hostname" type="text" class="input" value="127.0.0.1">
                        <span class="care">(通常为 127.0.0.1 或者指定端口 127.0.0.1:3306)</span>
                    </li>
                    <li>
                        数据库用户名<br/><input name="dbuser" type="text" class="input" value="">
                    </li>
                    <li>
                        数据库密码<br/><input name="dbpasswd" type="password" class="input">
                    </li>
                    <li>
                        数据库名<br/>
                        <input name="dbname" type="text" class="input" value="">
                        <span class="care">(程序不会自动创建数据库，请提前创建一个空数据库或使用已有数据库)</span>
                    </li>
                    <li>
                        数据库表前缀<br/>
                        <input name="dbprefix" type="text" class="input" value="emlog_">
                        <span class="care"> (通常默认即可，不必修改。由英文字母、数字、下划线组成，且必须以下划线结束)</span>
                    </li>
                </div>
			<?php endif; ?>
            <div class="c">
                <p class="title2">管理员设置</p>
                <li>
                    登录名<br/>
                    <input name="username" type="text" class="input">
                </li>
                <li>
                    密码<br/>
                    <input name="password" type="password" class="input">
                    <span class="care">(不小于6位)</span>
                </li>
                <li>
                    再次输入密码<br/>
                    <input name="repassword" type="password" class="input">
                </li>
                <li>
                    邮箱<br/>
                    <input name="email" type="text" class="input">
                    <span class="care"> (可用于找回密码，建议填写)</span>
                </li>
            </div>
            <div class="next_btn">
                <input type="submit" class="submit" value="下一步，开始安装">
            </div>
        </div>
    </form>
    <div class="footer">Powered by <a href="http://www.emlog.net">emlog</a></div>
    </body>
    </html>
	<?php
}
if ($act == 'install' || $act == 'reinstall') {
	$db_host = isset($_POST['hostname']) ? addslashes(trim($_POST['hostname'])) : '';
	$db_user = isset($_POST['dbuser']) ? addslashes(trim($_POST['dbuser'])) : '';
	$db_pw = isset($_POST['dbpasswd']) ? addslashes(trim($_POST['dbpasswd'])) : '';
	$db_name = isset($_POST['dbname']) ? addslashes(trim($_POST['dbname'])) : '';
	$db_prefix = isset($_POST['dbprefix']) ? addslashes(trim($_POST['dbprefix'])) : '';
	$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$repassword = isset($_POST['repassword']) ? addslashes(trim($_POST['repassword'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';

	if ($db_prefix === '') {
		emMsg('数据库表前缀不能为空!');
	} elseif (!preg_match("/^[\w_]+_$/", $db_prefix)) {
		emMsg('数据库表前缀格式错误!');
	} elseif (!$username || !$password) {
		emMsg('登录名和密码不能为空!');
	} elseif (strlen($password) < 6) {
		emMsg('登录密码不得小于6位');
	} elseif ($password != $repassword) {
		emMsg('两次输入的密码不一致');
	}

	define('DB_HOST', $db_host);
	define('DB_USER', $db_user);
	define('DB_PASSWD', $db_pw);
	define('DB_NAME', $db_name);
	define('DB_PREFIX', $db_prefix);

	$DB = Database::getInstance();
	$CACHE = Cache::getInstance();

	if ($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1) {
		echo <<<EOT
<html>
<head>
<meta charset="utf-8">
<title>emlog system message</title>
<style>
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:10px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid;}
.main p {line-height: 18px;margin: 5px 20px;}
</style>
</head><body>
<form name="form1" method="post" action="install.php?action=reinstall">
<div class="main">
    <input name="hostname" type="hidden" class="input" value="$db_host">
    <input name="dbuser" type="hidden" class="input" value="$db_user">
    <input name="dbpasswd" type="hidden" class="input" value="$db_pw">
    <input name="dbname" type="hidden" class="input" value="$db_name">
    <input name="dbprefix" type="hidden" class="input" value="$db_prefix">
    <input name="username" type="hidden" class="input" value="$username">
    <input name="password" type="hidden" class="input" value="$password">
    <input name="repassword" type="hidden" class="input" value="$repassword">
    <input name="email" type="hidden" class="input" value="$email">
<p>
你的emlog看起来已经安装过了。继续安装将会覆盖原有数据，确定要继续吗？
<input type="submit" value="继续&raquo;">
</p>
<p><a href="javascript:history.back(-1);">&laquo;点击返回</a></p>
</div>
</form>
</body>
</html>
EOT;
		exit;
	}

	if (!is_writable('config.php')) {
		emMsg('配置文件(config.php)不可写，请调整文件读写权限。');
	}
	if (!is_writable(EMLOG_ROOT . '/content/cache')) {
		emMsg('缓存目录（content/cache）不可写。请检查目录读写权限。');
	}
	$config = "<?php\n"
		. "//MySQL database host\n"
		. "const DB_HOST = '$db_host';"
		. "\n//Database username\n"
		. "const DB_USER = '$db_user';"
		. "\n//Database user password\n"
		. "const DB_PASSWD = '$db_pw';"
		. "\n//Database name\n"
		. "const DB_NAME = '$db_name';"
		. "\n//Database Table Prefix\n"
		. "const DB_PREFIX = '$db_prefix';"
		. "\n//Auth key\n"
		. "const AUTH_KEY = '" . getRandStr(32) . md5($_SERVER['HTTP_USER_AGENT']) . "';"
		. "\n//Cookie name\n"
		. "const AUTH_COOKIE_NAME = 'EM_AUTHCOOKIE_" . getRandStr(32, false) . "';";

	$fp = @fopen('config.php', 'w');
	$fw = @fwrite($fp, $config);
	if (!$fw) {
		emMsg('配置文件(config.php)不可写，请调整文件读写权限。');
	}
	fclose($fp);

	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$table_charset_sql = 'DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
	$DB->query("ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;", true);

	$widget_title = serialize(Option::getWidgetTitle());
	$def_widgets = serialize(Option::getDefWidget());
	$def_plugin = serialize(Option::getDefPlugin());

	$apikey = md5(getRandStr(32));

	define('BLOG_URL', realUrl());

	$sql = "
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid int(11) unsigned NOT NULL auto_increment COMMENT '文章表',
  title varchar(255) NOT NULL default '' COMMENT '文章标题',
  date bigint(20) NOT NULL COMMENT '发布时间',
  content longtext NOT NULL  COMMENT '文章内容',
  excerpt longtext NOT NULL  COMMENT '文章摘要',
  cover varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  alias varchar(255) NOT NULL DEFAULT '' COMMENT '文章别名',
  author int(11) NOT NULL default '1' COMMENT '作者UID',
  sortid int(11) NOT NULL default '-1' COMMENT '分类ID',
  type varchar(20) NOT NULL default 'blog' COMMENT '文章OR页面',
  views int(11) unsigned NOT NULL default '0' COMMENT '阅读量',
  comnum int(11) unsigned NOT NULL default '0' COMMENT '评论数量',
  attnum int(11) unsigned NOT NULL default '0' COMMENT '附件数量（已废弃）',
  top enum('n','y') NOT NULL default 'n' COMMENT '置顶',
  sortop enum('n','y') NOT NULL default 'n' COMMENT '分类置顶',
  hide enum('n','y') NOT NULL default 'n' COMMENT '草稿y',
  checked enum('n','y') NOT NULL default 'y' COMMENT '文章是否审核',
  allow_remark enum('n','y') NOT NULL default 'y' COMMENT '允许评论y',
  password varchar(255) NOT NULL default '' COMMENT '访问密码',
  template varchar(255) NOT NULL default '' COMMENT '模板',
  tags text COMMENT '标签',
  link varchar(255) NOT NULL DEFAULT '' COMMENT '文章跳转链接',
  PRIMARY KEY (gid),
  KEY author (author),
  KEY views (views),
  KEY comnum (comnum),
  KEY sortid (sortid),
  KEY top (top,date),
  KEY date (date)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,author,views,comnum,attnum,top,sortop,hide,allow_remark,password) VALUES (1, '欢迎使用emlog', '" . time() . "', '恭喜您成功安装了emlog，这是系统自动生成的演示文章。编辑或者删除它，然后开始您的创作吧！', '', 1, 0, 1, 0, 'n', 'n', 'n', 'y', '');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid int(11) unsigned NOT NULL auto_increment COMMENT '资源文件表',
  author int(11) unsigned NOT NULL default '1' COMMENT '作者UID',
  sortid int(11) NOT NULL default '0' COMMENT '分类ID',
  blogid int(11) unsigned NOT NULL default '0' COMMENT '文章ID（已废弃）',
  filename varchar(255) NOT NULL default '' COMMENT '文件名',
  filesize int(11) NOT NULL default '0' COMMENT '文件大小',
  filepath varchar(255) NOT NULL default '' COMMENT '文件路径',
  addtime bigint(20) NOT NULL default '0' COMMENT '创建时间',
  width int(11) NOT NULL default '0' COMMENT '图片宽度',
  height int(11) NOT NULL default '0' COMMENT '图片高度',
  mimetype varchar(40) NOT NULL default '' COMMENT '文件mime类型',
  thumfor int(11) NOT NULL default 0 COMMENT '缩略图的原资源ID（已废弃）',
  PRIMARY KEY  (aid),
  KEY thum_uid (thumfor,author)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}media_sort;
CREATE TABLE {$db_prefix}media_sort (
  id int(11) unsigned NOT NULL auto_increment COMMENT '资源分类表',
  sortname varchar(255) NOT NULL default '' COMMENT '分类名',
  PRIMARY KEY  (id)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid int(11) unsigned NOT NULL auto_increment COMMENT '评论表',
  gid int(11) unsigned NOT NULL default '0' COMMENT '文章ID',
  pid int(11) unsigned NOT NULL default '0' COMMENT '父级评论ID',
  top enum('n','y') NOT NULL default 'n' COMMENT '置顶',
  poster varchar(20) NOT NULL default '' COMMENT '发布人昵称',
  uid int(11) NOT NULL default '0' COMMENT '发布人UID',
  comment text NOT NULL COMMENT '评论内容',
  mail varchar(60) NOT NULL default '' COMMENT 'email',
  url varchar(75) NOT NULL default '' COMMENT 'homepage',
  ip varchar(128) NOT NULL default '' COMMENT 'ip address',
  agent varchar(512) NOT NULL default '' COMMENT 'user agent',
  hide enum('n','y') NOT NULL default 'n' COMMENT '是否审核',
  date bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY  (cid),
  KEY gid (gid),
  KEY date (date),
  KEY hide (hide)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}comment (gid, date, poster, comment) VALUES (1, '" . time() . "', 'snow', 'stay hungry stay foolish');
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment COMMENT '站点配置信息表',
option_name VARCHAR( 75 ) NOT NULL COMMENT '配置项',
option_value LONGTEXT NOT NULL COMMENT '配置项值',
PRIMARY KEY (option_id),
UNIQUE KEY `option_name_uindex` (`option_name`)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','EMLOG');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','使用emlog搭建的站点');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_title','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_description','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('log_title_style','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','" . BLOG_URL . "');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('footer_info','powered by <a href=\"https://www.emlog.net\">emlog pro</a>');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_perpage_num','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_num','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_fulltext','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','5');
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
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_maxsize','1024000');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_type','rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls,xlsx,mp4');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','600');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxh','370');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_paging','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_pnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_order','newer');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('iscomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias_html','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','Asia/Shanghai');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','$def_plugin');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_widget','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$def_widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('detect_url','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('emkey','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('email_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('is_signup','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkarticle','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('smtp_mail','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('smtp_pw','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('smtp_server','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('smtp_port','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('is_openapi','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('apikey','$apikey');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('posts_per_day',10);
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id int(11) unsigned NOT NULL auto_increment COMMENT '链接表',
  sitename varchar(255) NOT NULL default '' COMMENT '名称',
  siteurl varchar(255) NOT NULL default '' COMMENT '地址',
  description varchar(512) NOT NULL default '' COMMENT '备注信息',
  hide enum('n','y') NOT NULL default 'n' COMMENT '是否隐藏',
  taxis int(11) unsigned NOT NULL default '0' COMMENT '排序序号',
  PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog.net', 'http://www.emlog.net', 'emlog官方主页', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
  id int(11) unsigned NOT NULL auto_increment COMMENT '导航表',
  naviname varchar(30) NOT NULL default '' COMMENT '导航名称',
  url varchar(512) NOT NULL default '' COMMENT '导航地址',
  newtab enum('n','y') NOT NULL default 'n' COMMENT '在新窗口打开',
  hide enum('n','y') NOT NULL default 'n' COMMENT '是否隐藏',
  taxis int(11) unsigned NOT NULL default '0' COMMENT '排序序号',
  pid int(11) unsigned NOT NULL default '0' COMMENT '父级ID',
  isdefault enum('n','y') NOT NULL default 'n' COMMENT '是否系统默认导航，如首页',
  type tinyint(3) unsigned NOT NULL default '0' COMMENT '导航类型 0自定义 1首页 2笔记 3后台管理 4分类 5页面',
  type_id int(11) unsigned NOT NULL default '0' COMMENT '导航类型对应ID',
  PRIMARY KEY  (id)
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, '首页', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, '登录', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid int(11) unsigned NOT NULL auto_increment COMMENT '标签表',
  tagname varchar(60) NOT NULL default '' COMMENT '标签名',
  gid text NOT NULL COMMENT '文章ID',
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid int(11) unsigned NOT NULL auto_increment COMMENT '分类表',
  sortname varchar(255) NOT NULL default '' COMMENT '分类名',
  alias VARCHAR(255) NOT NULL DEFAULT '' COMMENT '别名',
  taxis int(11) unsigned NOT NULL default '0' COMMENT '排序序号',
  pid int(11) unsigned NOT NULL default '0' COMMENT '父分类ID',
  description text NOT NULL COMMENT '备注',
  template varchar(255) NOT NULL default '' COMMENT '分类模板',
  PRIMARY KEY  (sid)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid int(11) unsigned NOT NULL auto_increment COMMENT '用户表',
  username varchar(32) NOT NULL default '' COMMENT '用户名',
  password varchar(64) NOT NULL default '' COMMENT '用户密码',
  nickname varchar(20) NOT NULL default '' COMMENT '昵称',
  role varchar(60) NOT NULL default '' COMMENT '用户组',
  ischeck enum('n','y') NOT NULL default 'n' COMMENT '内容是否需要管理员审核',
  photo varchar(255) NOT NULL default '' COMMENT '头像',
  email varchar(60) NOT NULL default '' COMMENT '邮箱',
  description varchar(255) NOT NULL default '' COMMENT '备注',
  ip varchar(128) NOT NULL default '' COMMENT 'ip地址',
  state tinyint NOT NULL DEFAULT '0' COMMENT '用户状态 0正常 1禁用',
  create_time int(11) NOT NULL COMMENT '创建时间',
  update_time int(11) NOT NULL COMMENT '更新时间',
PRIMARY KEY  (uid),
KEY username (username),
KEY email (email)         
)" . $table_charset_sql . "
INSERT INTO {$db_prefix}user (uid, username, email, password, nickname, role, create_time, update_time) VALUES (1,'$username','$email','$password', 'emer','admin', " . time() . ", " . time() . ");
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT COMMENT '笔记表',
content text NOT NULL COMMENT '笔记内容',
img varchar(255) DEFAULT NULL COMMENT '图片',
author int(11) NOT NULL default '1' COMMENT '作者UID',
date bigint(20) NOT NULL COMMENT '创建时间',
replynum int(11) unsigned NOT NULL default '0' COMMENT '回复数量',
PRIMARY KEY (id),
KEY author (author)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}storage;
CREATE TABLE {$db_prefix}storage (
  `sid` int(8) NOT NULL AUTO_INCREMENT COMMENT '对象存储表',
  `plugin` varchar(32) NOT NULL COMMENT '插件名',
  `name` varchar(32) NOT NULL COMMENT '对象名',
  `type` varchar(8) NOT NULL COMMENT '对象数据类型',
  `value` text NOT NULL COMMENT '对象值',
  `createdate` int(11) NOT NULL COMMENT '创建时间',
  `lastupdate` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `plugin` (`plugin`,`name`)
)" . $table_charset_sql . "
DROP TABLE IF EXISTS {$db_prefix}tpl_options_data;
CREATE TABLE {$db_prefix}tpl_options_data (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `depend` varchar(64) NOT NULL DEFAULT '',
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template` (`template`,`name`)
)" . $table_charset_sql;

	$array_sql = preg_split("/;[\r\n]/", $sql);
	foreach ($array_sql as $sql) {
		$sql = trim($sql);
		if ($sql) {
			$DB->query($sql);
		}
	}
	$CACHE->updateCache();
	$result = '';
	$result .= "
        <p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">恭喜，安装成功</p>
        <p>emlog已经安装好了，现在可以开始你的创作了。</p>
        <p><b>用户名</b>：{$username}</p>
        <p><b>密 码</b>：刚才你设定的密码</p>";
	if ($env_emlog_env === 'develop' || ($env_emlog_env !== 'develop' && !@unlink('./install.php'))) {
		$result .= '<p style="color:#ff0000;margin:10px 20px;">警告：请手动删除根目录下安装文件：install.php</p> ';
	}
	$result .= "<p style=\"text-align:right;\"><a href=\"./\">访问首页</a> | <a href=\"./admin/\">登录后台</a></p>";
	emMsg($result, 'none');
}
?>