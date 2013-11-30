<?php
/*
Plugin Name: 沙发榜
Version: 1.0
Plugin URL: http://www.qiyuuu.com/for-emlog/emlog-plugin-sofa
Description: 比比看谁抢的沙发多哦～
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function sofa_update(){
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
	if($gid) {
		$DB = MySql::getInstance();
		$num = $DB->num_rows($DB->query("SELECT * FROM ".DB_PREFIX."comment WHERE gid={$gid} AND hide='n'"));
		if($num == 1) {
			require_once EMLOG_ROOT . '/content/plugins/sofa/class.sofa.php';
			sofa::getInstance()->update();
		}
	}
}
addAction('comment_saved','sofa_update');