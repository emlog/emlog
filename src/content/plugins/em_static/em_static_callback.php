<?php defined('EMLOG_ROOT') or die('access deined!');
function callback_init() {
	$db = MySql::getInstance();
	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $db->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
	$sql = "
	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emstatic_cronjob` (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`piror` TINYINT(1) NULL DEFAULT NULL,
		`locked` TINYINT(1) NULL DEFAULT NULL,
		`type` VARCHAR(10) NULL DEFAULT NULL,
		`data` VARCHAR(200) NULL DEFAULT NULL,
		`page` INT(10) NULL DEFAULT NULL,
		PRIMARY KEY (`id`),
		INDEX `piror` (`id`, `piror`, `locked`, `type`, `data`, `page`)
	)
	".$add;	
	$db->query($sql);
	$sql = "TRUNCATE `".DB_PREFIX."emstatic_cronjob`";
	$db->query($sql);
}

function callback_rm() {
	$sql = "TRUNCATE `".DB_PREFIX."emstatic_cronjob`";
	$db = MySql::getInstance();
	$db->query($sql);
	$index_file = EMLOG_ROOT.'/index.html';
	if (is_file($index_file)) {
		@unlink($index_file);
	}
}