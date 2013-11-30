<?php
/*
Plugin Name: something
Version: 1.0
Plugin URL:
Description: something
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
if(!function_exists('getmicrotime')) {
	function getmicrotime() {
		list($usec,$sec) = explode(' ',microtime());
		return (float)$usec + (float)$sec;
	}
}
global $startTime;
$startTime = getmicrotime();
function stats_js()
{
	global $startTime;
	$DB = MySql::getInstance();
	$endTime = getmicrotime();
	printf("%.6f", $endTime - $startTime);
	echo '秒 ';
	echo $DB->getQueryCount();
	echo '次';
}
addAction('index_footer','stats_js');