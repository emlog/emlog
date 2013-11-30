<?php
/*
Plugin Name: 自动跳转
Version: 1.0
Plugin URL:
Description: 判断浏览器是否为手机浏览器并自动跳转
Author: 奇遇
Author Email: qiyu@qiyuuu.com
Author URL: http://www.qiyuuu.com
*/
require_once EMLOG_ROOT . '/content/plugins/determin_browser/browser.class.php';
function bb() {
	$browser = new Browser();
	echo $browser->__toString();
}
addAction('index_footer','bb');