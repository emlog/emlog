<?php
/**
 * 升级程序3.3.0 to 3.4.0
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
<form name="form1" method="post" action="up3.3.0to3.4.0.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog <span style="color: #0099FF">3.3.0</span> to <span style="color: #FF0000; font-size:26px">3.4.0</span></span><span> 升级程序</span></p>
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
	if(EMLOG_VERSION != '3.4.0')
	{
		emMsg("错误操作：您必须完成升级步骤里的第一步才再进行本操作，详见安装说明");
	}

	$db_host = DB_HOST;
	$db_user = DB_USER;
	$db_pw   = trim($_POST['password']);
	$db_name = DB_NAME;
	$db_prefix = DB_PREFIX;
	
	unset($DB);
	unset($CACHE);

	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	$CACHE = new mkcache($DB, $db_prefix);

	$res = $DB->query("select option_value from {$db_prefix}options WHERE option_name='widget_title'");
	$row = $DB->fetch_array($res);
	$widgets = unserialize($row['option_value']);
	$widgets['twitter'] = str_replace('Twitter', '碎语', $widgets['twitter']);
	$widgets = serialize($widgets);

$sql = "
ALTER TABLE {$db_prefix}twitter ADD author INT(10) NOT NULL DEFAULT '1' AFTER content;
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isxmlrpcenable','n');
UPDATE {$db_prefix}options SET option_value='0' WHERE option_name='isurlrewrite' LIMIT 1;
UPDATE {$db_prefix}options SET option_value='$widgets' WHERE option_name='widget_title' LIMIT 1;
";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			$DB->query($query);
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
	$CACHE->mc_newlog();

	emMsg("恭喜你！emlog已成功升级到3.4.0 <a href=\"./\"> 进入博客&raquo; </a>");
}
echo "</body>";
echo "</html>";
?>