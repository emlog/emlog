<?php
/*
Plugin Name: 相关日志
Version: 1.3
Plugin URL:
Description: 在显示日志页面增加相关日志条目
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.emlog.net/qiyu/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function related_log_menu()
{
	echo '<div class="sidebarsubmenu" id="related_log"><a href="./plugin.php?plugin=related_log">相关日志</a></div>';
}
addAction('adm_sidebar_ext', 'related_log_menu');

function related_log($logData = array())
{
	require('related_log_config.php');
	global $value;
	$DB = MySql::getInstance();
	$CACHE = Cache::getInstance();
	extract($logData);
	if(!empty($value['content']))
	{
		$logid = $value['id'];
		$sortid = $value['sortid'];
		global $abstract;
	}
	$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog'";
	if($related_log_type == 'tag')
	{
		$log_cache_tags = $CACHE->readCache('logtags');
		$Tag_Model = new Tag_Model();
		$related_log_id_str = '0';
		foreach($log_cache_tags[$logid] as $key => $val)
		{
			$related_log_id_str .= ','.$Tag_Model->getTagByName($val['tagname']);
		}
		$sql .= " AND gid!=$logid AND gid IN ($related_log_id_str)";
	}else{
		$sql .= " AND gid!=$logid AND sortid=$sortid";
	}
	switch ($related_log_sort)
	{
		case 'views_desc':
		{
			$sql .= " ORDER BY views DESC";
			break;
		}
		case 'views_asc':
		{
			$sql .= " ORDER BY views ASC";
			break;
		}
		case 'comnum_desc':
		{
			$sql .= " ORDER BY comnum DESC";
			break;
		}
		case 'comnum_asc':
		{
			$sql .= " ORDER BY comnum ASC";
			break;
		}
		case 'rand':
		{
			$sql .= " ORDER BY rand()";
			break;
		}
	}
	$sql .= " LIMIT 0,$related_log_num";
	$related_logs = array();
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['gid'] = intval($row['gid']);
		$row['title'] = htmlspecialchars($row['title']);
		$related_logs[] = $row;
	}
	$out = '';
	if(!empty($related_logs))
	{
		$out .= "<div class=\"related_post\">";
		$out .= "<h3>相关日志：</h3><ul>";
		foreach($related_logs as $val)
		{
			$out .= "<li><a href=\"".Url::log($val['gid'])."\">{$val['title']}</a></li>";
		}
		$out .= "</ul></div>";
	}
	if(!empty($value['content']))
	{
		if($related_inrss == 'y')
		{
			$abstract .= $out;
		}
	}else{
		echo $out;
	}
}
addAction('rss_display','related_log');
addAction('log_related','related_log');
function related_log_get($logid, $sortid) {
	require('related_log_config.php');
	$DB = MySql::getInstance();
	$CACHE = Cache::getInstance();
	$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog'";
	if($related_log_type == 'tag')
	{
		$log_cache_tags = $CACHE->readCache('logtags');
		$Tag_Model = new Tag_Model();
		$related_log_id_str = '0';
		foreach($log_cache_tags[$logid] as $key => $val)
		{
			$related_log_id_str .= ','.$Tag_Model->getTagByName($val['tagname']);
		}
		$sql .= " AND gid!=$logid AND gid IN ($related_log_id_str)";
	}else{
		$sql .= " AND gid!=$logid AND sortid=$sortid";
	}
	switch ($related_log_sort)
	{
		case 'views_desc':
		{
			$sql .= " ORDER BY views DESC";
			break;
		}
		case 'views_asc':
		{
			$sql .= " ORDER BY views ASC";
			break;
		}
		case 'comnum_desc':
		{
			$sql .= " ORDER BY comnum DESC";
			break;
		}
		case 'comnum_asc':
		{
			$sql .= " ORDER BY comnum ASC";
			break;
		}
		case 'rand':
		{
			$sql .= " ORDER BY rand()";
			break;
		}
	}
	$sql .= " LIMIT 0,$related_log_num";
	$related_logs = array();
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['gid'] = intval($row['gid']);
		$row['title'] = htmlspecialchars($row['title']);
		$related_logs[] = $row;
	}
	return $related_logs;
}
?>