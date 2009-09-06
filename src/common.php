<?php
/**
 * Front-end global item loading
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('init.php');

//Read Cache
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

//Navigation bar
if(empty($navibar)) {
	$navibar = 'a:0:{}';
}
$navibar = unserialize(@$navibar);

//Background music
$music = @unserialize($options_cache['music']);
if ($music['mlinks'])
{
	$key = $music['randplay'] ? mt_rand(0,count($music['mlinks']) - 1) : 0 ;
	$musicurl = $music['mlinks'][$key];
	$musicdes = !empty($music['mdes'][$key]) ? $music['mdes'][$key] .'<br>' : '';
	$autoplay = $music['auto'] ? "&autoplay=1" : '';
}
