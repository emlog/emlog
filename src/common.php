<?php
/**
 * 前端全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id$
 */

require_once('init.php');

//读取缓存
$log_cache_tags = $CACHE->readCache('log_tags');
$log_cache_sort = $CACHE->readCache('log_sort');
$log_cache_atts = $CACHE->readCache('log_atts');
$newLogs_cache = $CACHE->readCache('newlogs');
$tag_cache = $CACHE->readCache('tags');
$sort_cache = $CACHE->readCache('sort');
$com_cache = $CACHE->readCache('comments');
$link_cache = $CACHE->readCache('links');
$user_cache = $CACHE->readCache('user');
$dang_cache = $CACHE->readCache('records');
$sta_cache = $CACHE->readCache('sta');
$tw_cache = $CACHE->readCache('twitter');

//模板目录
define('TEMPLATE_PATCH', './content/templates/');
//导航条
$navibar = unserialize($navibar);
//背景音乐
$music = @unserialize($options_cache['music']);
if ($music['mlinks'])
{
	$key = $music['randplay'] ? mt_rand(0,count($music['mlinks']) - 1) : 0 ;
	$musicurl = $music['mlinks'][$key];
	$musicdes = !empty($music['mdes'][$key]) ? $music['mdes'][$key] .'<br>' : '';
	$autoplay = $music['auto'] ? "&autoplay=1" : '';
}

?>
