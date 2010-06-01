<?php
/**
 * 升级程序3.4.0 to 3.5.0
 * @copyright (c) Emlog All Rights Reserved
 */
require_once('init.php');
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
	line-height:150%;}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:580px;
	margin:10px auto;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;}
.input {
	border: 1px solid #CCCCCC;
	font-family: Arial;
	font-size: 18px;
	height:28px;
	background-color:#F7F7F7;
	color: #666666;
	margin:5px 25px;}
.submit{
	background-color:#FFFFFF;
	border: 3px double #999;
	border-left-color: #ccc;
	border-top-color: #ccc;
	color: #333;
	padding: 0.25em;
	cursor:hand;}
.title{font-size:20px;font-weight:bold;}
.care{color:#0066CC;padding:0px 10px;}
.title2{font-size:14px;color:#000000;border-bottom: #CCCCCC 1px solid;}
.foot{text-align:center;}
li{border-bottom:#CCCCCC 1px dotted;margin:20px 20px;}
-->
</style>
<?php
if(!isset($_GET['action'])){
?>
<form name="form1" method="post" action="up3.4.0to3.5.0.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog <span style="color: #0099FF">3.4.0</span> to <span style="color: #FF0000; font-size:26px">3.5.0</span></span><span> 升级程序</span></p>
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
<input type="submit" class="submit" value="确 定">
<input type="reset" class="submit" value="重 置">
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

if (isset($_GET['action'])&&$_GET['action'] == "install") {
    $db_prefix = DB_PREFIX;
	if (EMLOG_VERSION != '3.5.0') {
		emMsg("错误操作：您必须完成升级步骤里的第一步才再进行本操作，详见安装说明");
	}

	if (DB_PASSWD != trim($_POST['password'])){
	    emMsg("输入的数据库密码错误,请重新输入");
	}

    if ($DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}reply'")) == 1) {
        emMsg("数据库已升级完成，请勿重复运行升级脚本");
    }
	
	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
	$extra2 = "TYPE=".$type;
	$DB->getMysqlVersion() > '4.1' ? $add = $extra:$add = $extra2.";";

	$res = $DB->query("select option_value from {$db_prefix}options WHERE option_name='widget_title'");
	$row = $DB->fetch_array($res);
	$widgets = unserialize($row['option_value']);
	$widgets['twitter'] = str_replace('碎语', '最新碎语', $widgets['twitter']);
	$widgets = serialize($widgets);

	$res = $DB->query("select option_value from {$db_prefix}options WHERE option_name='timezone'");
	$row = $DB->fetch_array($res);
	$timezone = intval($row['option_value']);
	$time_offset = ($timezone - 8) * 3600;

$sql = "
UPDATE {$db_prefix}blog SET date=date+$time_offset;
UPDATE {$db_prefix}comment SET date=date+$time_offset;
UPDATE {$db_prefix}twitter SET date=date+$time_offset;
UPDATE {$db_prefix}trackback SET date=date+$time_offset;
ALTER TABLE {$db_prefix}twitter CHANGE content content TEXT NOT NULL;
ALTER TABLE {$db_prefix}twitter ADD replynum MEDIUMINT(8) NOT NULL DEFAULT '0';
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newtwnum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('reply_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istwitter','y');
UPDATE {$db_prefix}options SET option_value='default' WHERE option_name='nonce_templet';
UPDATE {$db_prefix}options SET option_value='8' WHERE option_name='timezone';
UPDATE {$db_prefix}options SET option_value='$widgets' WHERE option_name='widget_title' LIMIT 1;
DROP TABLE IF EXISTS {$db_prefix}reply;
ALTER TABLE {$db_prefix}blog ADD INDEX date (date), ADD INDEX author (author), ADD INDEX sortid (sortid), ADD INDEX type (type), ADD INDEX hide (hide);
ALTER TABLE {$db_prefix}user ADD INDEX username (username);
ALTER TABLE {$db_prefix}twitter ADD INDEX author (author);
ALTER TABLE {$db_prefix}options ADD INDEX option_name (option_name);
ALTER TABLE {$db_prefix}comment ADD INDEX hide (hide);
CREATE TABLE {$db_prefix}reply (
  id mediumint(8) unsigned NOT NULL auto_increment,
  tid mediumint(8) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  name varchar(20) NOT NULL default '',
  content text NOT NULL,
  hide enum('n','y') NOT NULL default 'n',
  ip varchar(128) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY gid (tid),
  KEY hide (hide)
)".$add."
";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query) {
			$DB->query($query);
		}
	}
	$CACHE->updateCache();
	@unlink('./install.php');
	@unlink('./up3.4.0to3.5.0.php');
	@unlink('./calendar.php');
	@unlink('./twitter.php');
	emMsg("恭喜你！emlog已成功升级到3.5.0 <a href=\"./\"> 进入博客&raquo; </a>");
}
echo "</body>";
echo "</html>";
?>