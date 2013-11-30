<?php
/*
Plugin Name: cdn
Version: beta
Plugin URL:
Description: for static resource
ForEmlog: 5.1.2
Author: 奇遇
Author URL: http://www.qiyuuu.com
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function cdnReplace() {
	$content = ob_get_clean();
	$content = str_replace(BLOG_URL . 'content/', 'http://cdn.qiyuuu.com/', $content);
	ob_start();
	echo $content;
}

addAction('index_footer', 'cdnReplace');
