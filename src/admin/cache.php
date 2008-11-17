<?php
/**
 * 重建缓存
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./globals.php');

if ($action == '')
{
	include getViews('header');
	require_once(getViews('cache'));
	include getViews('footer');cleanPage();
}
if ($action == 'mkcache')
{
	$CACHE->mc_blogger('blogger');
	$CACHE->mc_options('options');
	$CACHE->mc_record('records');
	$CACHE->mc_comment('comments');
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_logatts('log_atts');
	$CACHE->mc_sta('sta');
	$CACHE->mc_link('links');
	$CACHE->mc_tags('tags');
	$CACHE->mc_twitter('twitter');
	formMsg('缓存更新成功', './cache.php',1);
}

?>

