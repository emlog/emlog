<?php
/*
Plugin Name: 404
Version: 1.0
Plugin URL:
Description: 404错误页
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function errorDocument($params) {
	$CACHE = Cache::getInstance();
	$options_cache = $CACHE->readCache('options');
	extract($options_cache);
	$navibar = unserialize($navibar);
	$curpage = CURPAGE_LOG;

	$log_title = '您要访问的页面未找到';
	$blogtitle = $log_title.' - '.$blogname;
	$log_content = '<p>貌似没有找到您要访问的页面，随便看看吧～<img src="'.BLOG_URL.'images/404.jpg" /></p>';
	$description = '这是一个不存在的页面';
	$allow_remark = 'n';
	$logid = $ckname = $ckmail = $ckurl = $verifyCode = '';
	$comments = array();
	header("HTTP/1.1 404 Not Found");
	include View::getView('header');
	include View::getView('page');
	exit;
}
function getKeyword() {
	$referer = isset($_SERVER['HTTP_REFERER']) ? addslashes(strtolower($_SERVER['HTTP_REFERER'])) : '';
	if($referer) {
		preg_match("/^https?:\/\/([^\:\/]+)(.*)$/i", $referer, $matches);
		$host = $matches[1];
		$queryString = $matches[2];
		parse_str($queryString, $query);
		if(strstr($host, 'baidu') !== false) {
			$keyword = isset($query['wd']) ? iconv('GBK','UTF-8',urldecode($query['wd'])) : '';
			$searchEngine = '百度';
		} elseif(strstr($host, 'google') !== false) {
			$keyword = isset($query['q']) ? $query['q'] : '';
			if(isset($query['ie']) && $query['ie'] == 'gb') {
				$keyword = iconv('gb2312','utf8',$keyword);
			}
			$keyword = urldecode($keyword);
			$searchEngine = 'Google';
		}
		if($keyword == '') return '';
		return compact('keyword','searchEngine');
	}
	return '';
}