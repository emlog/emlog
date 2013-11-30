<?php
/*
Plugin Name: sitemap
Version: 2.0
Plugin URL: http://www.qiyuuu.com/for-emlog/emlog-plugin-sitemap
Description: 生成sitemap，供搜索引擎抓取
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function sitemap_update() {
	require_once EMLOG_ROOT . '/content/plugins/sitemap/class.sitemap.php';
	extract(sitemap_config());
	$sitemap = new sitemap($sitemap_name);
	return $sitemap->build();
}
function sitemap_del($logid) {
	global $sitemap_name;
	$url = Url::log($logid);
	$file = EMLOG_ROOT . '/' . $sitemap_name;
	$xml = file_get_contents($file);
	$xml = preg_replace("|<url>\n<loc>".preg_quote($url)."<\/loc>.*?<\/url>\n|is","",$xml);
	file_put_contents($file,$xml);
}
function sitemap_update_on_comment() {
	global $sitemap_name;
	if(Option::get('ischkcomment') == 'n') return;
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
	$url = Url::log($gid);
	$lastmod = gmdate('c');
	$file = EMLOG_ROOT . '/' . $sitemap_name;
	$xml = file_get_contents($file);
	$xml = preg_replace("|<loc>".preg_quote($url)."<\/loc>\n<lastmod>(.*?)<\/lastmod>|i","<loc>$url</loc>\n<lastmod>$lastmod</lastmod>",$xml);
	file_put_contents($file,$xml);
}
function sitemap_footer() {
	global $sitemap_name;
	echo '<a href="' . BLOG_URL . $sitemap_name . '" rel="sitemap">sitemap</a>';
}
function sitemap_menu() {
	echo '<div class="sidebarsubmenu" id="sitemap"><a href="./plugin.php?plugin=sitemap">sitemap</a></div>';
}
function sitemap_config() {
	return @unserialize(file_get_contents(EMLOG_ROOT . '/content/plugins/sitemap/config'));
}
extract(sitemap_config());
addAction('save_log','sitemap_update');
addAction('del_log','sitemap_del');
if($sitemap_comment_time) {
	addAction('comment_saved','sitemap_update_on_comment');
}
if($sitemap_show_footer) {
	addAction('index_footer','sitemap_footer');
}
if(Option::get('istwitter') == 'y') {
	addAction('post_twitter','sitemap_update');
}
addAction('adm_sidebar_ext', 'sitemap_menu');