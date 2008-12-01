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
	$CACHE->mc_blogger();
	$CACHE->mc_options();
	$CACHE->mc_record();
	$CACHE->mc_comment();
	$CACHE->mc_logtags();
	$CACHE->mc_logsort();
	$CACHE->mc_logatts();
	$CACHE->mc_sta();
	$CACHE->mc_link();
	$CACHE->mc_tags();
	$CACHE->mc_sort();
	$CACHE->mc_twitter();
	$CACHE->mc_newlog();
	header("Location: ./cache.php?active_mc=true");
}

?>

