<?php
include '../../../init.php';
header('Content-type: text/javascript; charset=utf-8;');

if ( ! isset($GLOBALS['em_static_config_data']) || $GLOBALS['em_static_config_data']['enable_auto_create'] == 0) {
	header('HTTP/1.1 200 OK');
	exit();
}

$db = Mysql::getInstance();
// 先执行高优先级的任务
$sql = 'SELECT 
			id, 
			type, 
			data, 
			page 
		FROM '.DB_PREFIX.'emstatic_cronjob 
		WHERE 
			locked = 0 
			AND piror = 1 
		ORDER BY id ASC 
		LIMIT '.intval($GLOBALS['em_static_config_data']['auto_create_performance_value']);
$query = $db->query($sql);
if ($db->num_rows($query) > 0) {
	while ($cron = $db->fetch_array($query)) {
		em_static_cron_job($cron);
	}
} else {
	// 如果高优先级的任务已经完成则执行普通优先级任务
	$sql = 'SELECT
				id,
				type,
				data,
				page
			FROM '.DB_PREFIX.'emstatic_cronjob
			WHERE
				locked = 0
				AND piror = 0
			ORDER BY id ASC
			LIMIT '.intval($GLOBALS['em_static_config_data']['auto_create_performance_value']);
	$query = $db->query($sql);
	if ( $query) {
		while ($cron = $db->fetch_array($query)) {
			em_static_cron_job($cron);
		}
	}
}

function em_static_cron_job($cron) {
	global $db;
	$em_static = EMStatic::get_instance();
	$sql = 'UPDATE '.DB_PREFIX.'emstatic_cronjob SET locked = 1 WHERE id = '.$cron['id'];
	$db->query($sql);
	
	if ($cron['type'] == 'index') {
		$em_static->create_index_page();
	}
	
	if ($cron['type'] == 'page') {
		$em_static->create_pagination_page($cron['page']);
	}
	
	if ($cron['type'] == 'tag') {
		list($tid, $tag_name, $tag_alias) = explode(',', $cron['data']);
		if (empty($tag_alias)) {
			$tag_alias = EMStatic_Pinyin::get_instance()->cover($tag_name);
		}
		if ($cron['page'] == 1) {
			$em_static->create_tag_index_page($tag_name, $tag_alias);
		} else {
			$em_static->create_tag_page($tag_name, $tag_alias, $cron['page']);
		}
	}
	
	if ($cron['type'] == 'post') {
		list($gid, $alias) = explode(',', $cron['data']);
		$em_static->create_post_page($gid, $alias);
	}
	
	if ($cron['type'] == 'sort') {
		list($sid, $alias) = explode(',', $cron['data']);
		$em_static->create_post_page($sid, $alias);
	}
	
	if ($cron['type'] == 'author') {
		if ($cron['page'] == 1) {
			$em_static->create_author_index_page($cron['data']);
		} else {
			$em_static->create_author_page($cron['data'], $cron['page']);
		}
	}
	
	if ($cron['type'] == 'record') {
		if ($cron['page'] == 1) {
			$em_static->create_record_index_page($cron['data']);
		} else {
			$em_static->create_record_page($cron['data'], $cron['page']);
		}
	}
	
	$sql = 'DELETE FROM '.DB_PREFIX.'emstatic_cronjob WHERE id = '.$cron['id'];
	$db->query($sql);
}
unset($db);