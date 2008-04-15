<?php
/**
 * 重建缓存
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
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
	$MC->mc_blogger('../cache/blogger');
	$MC->mc_config('../cache/config');
	$MC->mc_record('../cache/records');
	$MC->mc_comment('../cache/comments');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_logatts('../cache/log_atts');
	$MC->mc_sta('../cache/sta');
	$MC->mc_link('../cache/links');
	$MC->mc_tags('../cache/tags');
	$MC->mc_twitter('../cache/twitter');
	formMsg('缓存更新成功', './cache.php',1);
}

?>

