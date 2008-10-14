<?php
/**
 * 重建缓存
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
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
	$CACHE->mc_blogger('../cache/blogger');
	$CACHE->mc_config('../cache/config');
	$CACHE->mc_record('../cache/records');
	$CACHE->mc_comment('../cache/comments');
	$CACHE->mc_logtags('../cache/log_tags');
	$CACHE->mc_logatts('../cache/log_atts');
	$CACHE->mc_sta('../cache/sta');
	$CACHE->mc_link('../cache/links');
	$CACHE->mc_tags('../cache/tags');
	$CACHE->mc_twitter('../cache/twitter');
	formMsg('缓存更新成功', './cache.php',1);
}

?>

