<?php
/*
Plugin Name: sitemap
Version: 1.0
Plugin URL: http://www.qiyuuu.com/for-emlog/emlog-plugin-sitemap
Description: 生成sitemap，供搜索引擎抓取
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function callback_init() {
	require_once EMLOG_ROOT . '/content/plugins/sitemap/class.sitemap.php';
	require_once EMLOG_ROOT . '/content/plugins/sitemap/sitemap.php';
	extract(sitemap_config());
	$sitemap = new sitemap($sitemap_name);
	$sitemap->build();
}