<?php
!defined('EMLOG_ROOT') && exit('access deined!');

if (!class_exists('TplOptions', false)) {
	include __DIR__ . '/tpl_options.php';
}

//插件激活回调函数
function callback_init() {
	$tplOptions = TplOptions::getInstance();
	$table = $tplOptions->getTable('data');
	$dbcharset = 'utf8mb4';
	$type = 'InnoDB';
	$add = $tplOptions->getDb()->getMysqlVersion() > '4.1' ? "ENGINE=$type DEFAULT CHARSET=$dbcharset;" : "TYPE=$type;";
	$sql = "
	CREATE TABLE IF NOT EXISTS `$table` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`template` char(64) NOT NULL,
		`name` char(64) NOT NULL,
		`depend` char(64) NOT NULL DEFAULT '',
		`data` longtext NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `template` (`template`,`name`)
	)" . $add;
	$tplOptions->getDb()->query($sql);
}
