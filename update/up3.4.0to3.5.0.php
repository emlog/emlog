<?php
/**
 * 升级程序3.4.0 to 3.5.0
 * @copyright (c) Emlog All Rights Reserved
 */
require_once 'init.php';
$step = isset($_GET['step']) ? trim($_GET['step']) : 'one';
$steps = array('one', 'two', 'three', 'four', 'five');

if (!in_array($step, $steps)) {
	em_error('升级参数错误!');
}

call_user_func('step_' . $step);


function step_one() {
	em_header();
	?>
	<form method="get" action="">
	<input type="hidden" name="step" value="two" />
			<div>
				<p class="title">升级步骤一</p>
				<p>请确认将您下载的emlog3.5的源代码上传并覆盖。</p>
				<p>并注意<font color="red"><b>不要覆盖 config.php</b></font></p>
				<p class="foot"><input type="submit" class="submit" value="我已经确认完成了这个步骤"></p>
			</div>
	</form>
	<?php
	em_footer();
}

function step_two() {
    if (EMLOG_VERSION != '3.5.0') {
		em_error("您必须完成升级步骤里的第一步才再进行本操作，详见安装说明");
	}
	em_header();
	?>
	<form method="post" action="?step=three">
		<div>
			<p class="title">升级步骤二</p>
			<p>我们在emlog3.5.0 中新增加了一些新功能和特性，因此需要对您博客的数据库结构进行升级操作。</p>
			<p>请填写您博客数据库的密码以确认您的身份。</p>
			<p style="color:red">如果您忘记了数据库的密码，可以在 config.php 中的 DB_PASSWD 项目中找到它。</p>
		<div>
		<div class="b">
			<li>
				<strong>数据库密码：</strong><br />
				<input name="password" type="password" class="input" value="" />
			</li>
		</div>
		<p class="foot">
			<input type="submit" class="submit" value="开始升级数据库">
			<input type="reset" class="submit" value="重新填写密码">
		</p>
	</form>
	<?php
	em_footer();
}

function step_three() {
	em_header();
	if (DB_PASSWD != trim($_POST['password'])) {
	    em_error("输入的数据库密码错误, 请重新输入");
	}


	?>
	<form method="get">
		<div>
			<p class="title">升级步骤三 </p>
			<?php
				if (!$conn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWD)) {
					?>
					<p>连接数据库失败!</p>
					<p>错误信息</p>
					<p><?php echo mysql_error();?></p>
					<?php
				} else {
					if (mysql_get_server_info() > '4.1') {
						mysql_query("SET NAMES 'utf8'");
					}
					if (!mysql_select_db(DB_NAME, $conn)) {
						?>
						<p>选择数据库失败!</p>
						<p>错误信息</p>
						<p><?php echo mysql_error();?></p>
						<?php
					} else {
						// 开始更新数据
						$db_prefix = DB_PREFIX;
						$dbcharset = 'utf8';
						$type   = 'MYISAM';
						$extra  = "ENGINE=$type DEFAULT CHARSET=$dbcharset;";
						$extra2 = "TYPE=$type";
						$res = mysql_query("SELECT option_value FROM {$db_prefix}options WHERE option_name = 'widget_title'");
						$row = mysql_fetch_array($res);
						$widgets = unserialize($row['option_value']);
						$widgets['twitter'] = str_replace('碎语', '最新碎语', $widgets['twitter']);
						$widgets = serialize($widgets);

						$res = mysql_query("SELECT option_value FROM {$db_prefix}options WHERE option_name = 'timezone'");
						$row = mysql_fetch_array($res);
						$timezone = intval($row['option_value']);
						$time_offset = ($timezone - 8) * 3600;
						$sql_step = array(
							"UPDATE {$db_prefix}blog SET date=date+$time_offset;",
							"UPDATE {$db_prefix}comment SET date=date+$time_offset;",
							"UPDATE {$db_prefix}twitter SET date=date+$time_offset",
							"UPDATE {$db_prefix}trackback SET date=date+$time_offset",
							"ALTER TABLE {$db_prefix}twitter CHANGE content content TEXT NOT NULL",
							"ALTER TABLE {$db_prefix}twitter ADD replynum MEDIUMINT(8) NOT NULL DEFAULT '0'",
							"INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newtwnum','5')",
							"INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('reply_code','n')",
							"INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkreply','n')",
							"INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istwitter','y')",
							"UPDATE {$db_prefix}options SET option_value='default' WHERE option_name='nonce_templet'",
							"UPDATE {$db_prefix}options SET option_value='8' WHERE option_name='timezone'",
							"UPDATE {$db_prefix}options SET option_value='$widgets' WHERE option_name='widget_title' LIMIT 1",
							"DROP TABLE IF EXISTS {$db_prefix}reply",
							"ALTER TABLE {$db_prefix}blog ADD INDEX date (date), ADD INDEX author (author), ADD INDEX sortid (sortid), ADD INDEX type (type), ADD INDEX hide (hide)",
							"ALTER TABLE {$db_prefix}user ADD INDEX username (username)",
							"ALTER TABLE {$db_prefix}twitter ADD INDEX author (author)",
							"ALTER TABLE {$db_prefix}options ADD INDEX option_name (option_name)",
							"ALTER TABLE {$db_prefix}comment ADD INDEX hide (hide)",
							"CREATE TABLE {$db_prefix}reply (
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
							){$add}"
						);
						$error_step = isset($_COOKIE['error_step']) ? intval($_COOKIE['error_step']) : -1;
						$query_error = false;
						foreach ($sql_step as $key => $sql) {
							if ($error_step > 1 && $key < $error_step) {
								?>
								<p>步骤<?php echo $key + 1?>(已完成，自动跳过）</p>
								<?php
								continue;
							}
							if ($sql) {
								if (mysql_query(trim($sql))) {
									?><p>数据升级步骤<?php echo $key + 1?>完成</p><?php
								} else {
									?>
										<p style="color:red;font-weight:bold">数据升级步骤<?php echo $key + 1?>出现错误</p>
										<p>数据库错误信息</p>
										<p><?php echo mysql_error();?></p>
										<p>请解决该问题后重新执行升级本步骤，程序会自动从您出现问题的位置开始继续更新数据库</p>
									<?php
									setcookie('error_step', $key, time() + 3600);
									$query_error = true;
									break;
								}
							}
						}
						if ($query_error == false) {
							mkcache::getInstance()->updateCache();
							@unlink('./install.php');
							@unlink('./calendar.php');
							@unlink('./twitter.php');
							?>
							<p style="color:green;font-weight:bold">恭喜您！数据库升级成功！</p>
							<p class="foot">
								<input type="hidden" name="step" value="four" />
								<input type="submit" class="submit" value="进入下一步骤">
							</p>
							<?php
						} else {
							?>
							<p class="foot">
								<input type="hidden" name="step" value="two" />
								<input type="submit" class="submit" value="返回上一步骤">
							</p>
							<?php
						}
					}
				}
			?>
		<div>

	</form>
	<?php
	em_footer();
}

function step_four() {
		em_header();
	?>
	<form method="post" action="?step=five" id="theform">
		<div>
			<p class="title">升级步骤四</p>
			<p style="color:green;font-weight:bold">恭喜您，到这里Blog主要的升级工作已经完成了！</p>
			<p>由于emlog3.4的模版、插件和新版本存在兼容性问题，您需要去emlog官方网站下载您正在使用的模版和插件的最近版本并更新，以免由于程序兼容问题导致您的博客出现故障。我们将暂时把您的模板切换为默认模板</p>
			<p>同时，我们强烈建议您现在暂时禁用安装的所有插件。您可以在把它们更新到最新版本之后再启用.</p>
		<div>
		<p class="foot">
			<input type="hidden" name="close" value="1" id="close"/>
			<input type="submit" class="submit" value="好的，禁用所有插件" />
			<input type="submit" onclick="return ask_to_confirm();"class="submit" value="不用，我会自行禁用插件" />
		</p>
		<script type="text/javascript">
			function ask_to_confirm() {
				if (confirm('确定不禁用插件和更换模板吗?')) {
					document.getElementById('close').value = '1';
					return true;
				} else {
					return false;
				}
			}
		</script>
	</form>
	<?php
	em_footer();
}

function step_five() {
	em_header();
	$close = isset($_POST['close']) ? intval($_POST['close']) : 1;
	$db = MySql::getInstance();
	$db->query("UPDATE ". DB_PREFIX . "options SET option_value = 'default' WHERE option_name = 'nonce_templet'");
	if ($close == 1) {
		$db->query("UPDATE ". DB_PREFIX . "options SET option_value = '". serialize(array('tips/tips.php')) ."' WHERE option_name = 'active_plugins'");
	}
    mkcache::getInstance()->updateCache('options');
	?>
		<div>
			<p class="title">升级完成！</p>
			<p style="color:green;font-weight:bold">恭喜你，emlog3.5的升级步骤全部完成了！</p>
			<p><a href="./">访问博客首页</a></p>
			<p><a href="./admin/index.php">登陆博客后台</a></p>
		<div>
	<?php
	em_footer();
	@unlink('./up3.4.0to3.5.0.php');
}

function em_error($message) {
	ob_clean();
	ob_start();
	em_header();
	?>
		<div>
			<p class="title">出现错误！</p>
			<p style="color:red;font-weight:bold"><?php echo $message?></p>
			<p><a href="javascript:history.back(-1);">返回前一个页面</a></p>
		<div>
	<?php
	em_footer();
	die;
}

function em_header() {
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
		padding:20px 0px 5px 0px;
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
	</header>
	<body>
		<div class="main">
			<div>
				<p>
					<span class="title">emlog <span style="color: #0099FF">3.4.0</span> to <span style="color: #FF0000; font-size:26px">3.5.0</span></span>
					<span> 升级程序</span>
				</p>
	<?php
}

function em_footer() {
	?>
		</div>
	</body>
	</html>
	<?php
}
?>