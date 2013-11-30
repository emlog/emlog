<?php
/**
 * kl_comment_manage_callback.php
 * design by KLLER
 */
function callback_init()
{
	$DB = MySql::getInstance();
	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
	$sql = "
	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."kl_comment_manage` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`field` enum('ip','mail','comment','url','poster','gid') NOT NULL,
		`sign` enum('eq','neq','leq','req','like') NOT NULL,
		`keyword` varchar(255) NOT NULL,
		`operate` enum('pub','hide','anti') NOT NULL,
		`hits` int(11) NOT NULL DEFAULT '0',
		`disabled` tinyint(1) NOT NULL DEFAULT '0',
		`last_hits_time` int(11) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	)".$add;	
	$DB->query($sql);
	$is_exist_new_columns_query = $DB->query('show columns from '.DB_PREFIX.'kl_comment_manage like "cau_time"');
	if($DB->num_rows($is_exist_new_columns_query) == 0){
		$sql = "ALTER TABLE `".DB_PREFIX."kl_comment_manage` ADD COLUMN `cau_time` INT(11) DEFAULT 0 NOT NULL AFTER `last_hits_time`;";
		$DB->query($sql);
		$sql = "UPDATE `".DB_PREFIX."kl_comment_manage` SET `cau_time`=UNIX_TIMESTAMP(NOW());";
		$DB->query($sql);
	}
}

function callback_rm(){}