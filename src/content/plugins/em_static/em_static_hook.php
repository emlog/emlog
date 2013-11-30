<?php
include '../../../init.php';
header('Content-type: text/html; charset=utf-8;');

if ( ! ISLOGIN) {
	header('HTTP/1.1 404 Not Found');
	exit();
}

$action = isset($_GET['do']) ? $_GET['do'] : 'create_start';
$action_funtion = 'em_static_'.$action;
if (function_exists($action_funtion)) {
	call_user_func($action_funtion);
}

function em_static_create_start() {
	$create_pages = isset($_POST['create_pages']) ? $_POST['create_pages'] : NULL;
	if ( ! $create_pages) 
		return;
	
	$data['create_pages'] = array_reverse($create_pages);
	$data['time_start'] = time();
	$data['limits'] = array();
	$data['limits']['post_limit'] = isset($_POST['post_limit']) ? intval($_POST['post_limit']) : NULL;
	$data['limits']['list_limit'] = isset($_POST['list_limit']) ? intval($_POST['list_limit']) : NULL;
	$data['limits']['comment_limit'] = isset($_POST['comment_limit']) ? intval($_POST['comment_limit']) : NULL;
	$data['limits']['sort_limit'] = isset($_POST['sort_limit']) ? $_POST['sort_limit'] : NULL;
	$data['limits']['tag_limit'] = isset($_POST['tag_limit']) ? $_POST['tag_limit'] : NULL;
	$data['limits']['author_limit'] = isset($_POST['author_limit']) ? $_POST['author_limit'] : NULL;
	$data['limits']['record_limit'] = isset($_POST['record_limit']) ? $_POST['record_limit'] : NULL;
	$data['limits']['static_limit'] = isset($_POST['static_limit']) ? $_POST['static_limit'] : NULL;		
	em_static_go_to_next_step($data, '静态页面生成开始');
}

function em_static_create_log_start() {
	$logs = isset($_POST['logid']) ? $_POST['logid'] : NULL;
	if ( ! $logs || ! is_array($logs)) 
		return;	
	$data['time_start'] = time();
	$data['create_pages'] = array_reverse(array('index', 'post', 'page', 'sort', 'tag',  'author',  'record'));
	$db = MySql::getInstance();
	$logcache = Cache::getInstance()->readCache('logtags');
	$data['post_ids'] = $data['sort_ids'] = $data['tag_ids'] = $data['author_ids'] = array();
	$record_date = 0;
	foreach($logs as $log) {
		$sql = 'SELECT gid, sortid, author, date FROM '.DB_PREFIX.'blog WHERE hide = \'n\' AND gid = '.intval($log);
		$row = $db->once_fetch_array($sql);
		if ($row) {
			if ($record_date == 0)
				$record_date = $row['date'];
			elseif ($row['date'] < $record_date)
				$record_date = $row['date'];
				
			if (! in_array($row['gid'], $data['post_ids']))
				$data['post_ids'][] = $row['gid'];			
			if ($row['sortid'] != '-1' && ! in_array($row['sortid'], $data['sort_ids']))
				$data['sort_ids'][] = $row['sortid'];
			if (! in_array($row['author'], $data['author_ids']))
				$data['author_ids'][] = $row['author'];
			if (isset($logcache[$row['gid']]) && !empty($logcache[$row['gid']])) {
				$tags = $logcache[$row['gid']];
				foreach ($tags as $tag) {
					if (! in_array($tag['tid'], $data['tag_ids']))
						$data['tag_ids'][] = $tag['tid'];					
				}
			}
		}
	}
	$data['record_date'] = gmdate('Ym', $record_date);
	$data['limits'] = array();
	$data['limits']['post_limit'] = 5;
	$data['limits']['list_limit'] = 5;
	$data['limits']['comment_limit'] = 5;
	$data['limits']['sort_limit'] = 5;
	$data['limits']['tag_limit'] = 5;
	$data['limits']['author_limit'] = 5;
	$data['limits']['record_limit'] = 5;
	$data['limits']['static_limit'] = 5;	
	em_static_go_to_next_step($data, '静态页面生成开始');	
}

function em_static_create_index() {
	$data = em_static_get_data();
	EMStatic::get_instance()->create_index_page();
	em_static_go_to_next_step($data, '首页生成完成');
}

function em_static_create_post() {
	$data = em_static_get_data();
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 0;
	$limit = $data['limits']['post_limit'];
	$em_static = EMStatic::get_instance();
	if ( ! isset($data['post_ids']) || empty($data['post_ids'])) {
		if ($em_static->create_post_pages($limit_start, $limit)) {
			$start = $limit_start + 1;
			$end = $limit_start + $limit;
			em_static_continue_create($data, "第{$start}至{$end}篇日志生成完毕。", $limit_start + $limit);
		} else {
			em_static_go_to_next_step($data, '日志页面生成完毕');
		}
	} else {
		$db = Mysql::getInstance();
		foreach ($data['post_ids'] as $post_id) {
			$sql = 'SELECT gid, alias FROM '.DB_PREFIX.'blog WHERE gid = '.intval($post_id);
			$row = $db->once_fetch_array($sql);
			$em_static->create_post_page($row['gid'], $row['alias']);
		}
		em_static_go_to_next_step($data, '日志页面生成完毕');
	}
}

function em_static_create_page() {
	$data = em_static_get_data();
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 1;
	$limit = $data['limits']['list_limit'];
	$em_static = EMStatic::get_instance();
	if ($em_static->create_pagination_pages($limit_start, $limit)) {
		$start = $limit_start;
		$end = $limit_start + $limit - 1;
		em_static_continue_create($data, "日志列表第{$start}至{$end}页生成中...", $limit_start + $limit);
	} else {
		em_static_go_to_next_step($data, '所有日志分页列表页面生成完毕');
	}
}

function em_static_create_sort() {
	$data = em_static_get_data();
	$db = Mysql::getInstance();
	$em_static = EMStatic::get_instance();
	
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
	$before_sid = isset($_GET['before_sid']) ? intval($_GET['before_sid']) : 0;
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 2;
	$limit = $data['limits']['sort_limit'];
	
	if (! isset($data['sort_ids']) || empty($data['sort_ids'])) {
		$where = 'sid > '.$before_sid;
		if ($sid)
			$where = 'sid = '.$sid;
		$sql = 'SELECT sid, alias, sortname FROM '.DB_PREFIX.'sort WHERE '.$where.' ORDER BY sid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$sort = $db->fetch_array($query);
			if ($em_static->create_sort_pages($sort['sid'], $sort['alias'], $limit_start, $limit)) {
				em_static_continue_create($data, "分类{$sort['sortname']}页生成中。", $limit_start + $limit, '&sid='.$sort['sid']);		
			} else {
				em_static_continue_create($data, "分类{$sort['sortname']}分页页面全部生成完毕。", 2, '&before_sid='.$sort['sid']);
			}
		} else {
			em_static_go_to_next_step($data, '所有分类日志列表页面生成完毕');
		}
	} else {
		$index = $before_sid ? intval($before_sid) : 0;
		if (! isset($data['sort_ids'][$index])) {
			em_static_go_to_next_step($data, '所有分类日志列表页面生成完毕');
			return;
		}
		$where = ' sid = '. $data['sort_ids'][$index];
		$sql = 'SELECT sid, alias, sortname FROM '.DB_PREFIX.'sort WHERE '.$where.' ORDER BY sid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$sort = $db->fetch_array($query);
			if ($em_static->create_sort_pages($sort['sid'], $sort['alias'], $limit_start, $limit)) {
				em_static_continue_create($data, "分类{$sort['sortname']}页生成中。", $limit_start + $limit, '&before_sid='.$index);		
			} else {
				em_static_continue_create($data, "分类{$sort['sortname']}分页页面全部生成完毕。", 2, '&before_sid='.++$index);
			}
		} else {
			em_static_go_to_next_step($data, '所有分类日志列表页面生成完毕');
		}	
	}
}

function em_static_create_tag() {
	$data = em_static_get_data();
	$db = Mysql::getInstance();
	$em_static = EMStatic::get_instance();
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
	$before_tid = isset($_GET['before_tid']) ? intval($_GET['before_tid']) : 0;
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 2;
	$limit = $data['limits']['tag_limit'];
	$em_tag_cache = array();
	if (is_file(EM_STATIC_TAG_CACHE_FILE))
		$em_tag_cache = include EM_STATIC_TAG_CACHE_FILE;
	
	if (! isset($data['tag_ids']) || empty($data['tag_ids'])) {
		$where = 'tid > '.$before_tid;
		if ($tid)
			$where = 'tid = '.$tid;
		$sql = 'SELECT tid, tagname, gid FROM '.DB_PREFIX.'tag WHERE '.$where.' ORDER BY tid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$tag = $db->fetch_array($query);
			if (isset($em_tag_cache[$tag['tid']])) {
				$tag_alias = $em_tag_cache[$tag['tid']];
			} else {
				$tag_alias = EMStatic_Pinyin::get_instance()->cover($tag['tagname']);
			}
			if ($em_static->create_tag_pages($tag['tagname'], $tag_alias, $tag['gid'], $limit_start, $limit)) {
				em_static_continue_create($data, "标签{$tag['tagname']}分页页面生成中。", $limit_start + $limit, '&tid='.$tag['tid']);		
			} else {
				em_static_continue_create($data, "标签{$tag['tagname']}分页页面全部生成完毕。", 2, '&before_tid='.$tag['tid']);
			}
		} else {
			em_static_go_to_next_step($data, '所有标签日志列表页面生成完毕');
		}
	} else {
		$index = $before_tid ? intval($before_tid) : 0;
		if (! isset($data['tag_ids'][$index])) {
			em_static_go_to_next_step($data, '所有标签日志列表页面生成完毕');
			return;
		}
		$where = ' tid = '. $data['tag_ids'][$index];
		$sql = 'SELECT tid, tagname, gid FROM '.DB_PREFIX.'tag WHERE '.$where.' ORDER BY tid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$tag = $db->fetch_array($query);
			if (isset($em_tag_cache[$tag['tid']])) {
				$tag_alias = $em_tag_cache[$tag['tid']];
			} else {
				$tag_alias = EMStatic_Pinyin::get_instance()->cover($tag['tagname']);
			}
			if ($em_static->create_tag_pages($tag['tagname'], $tag_alias, $tag['gid'], $limit_start, $limit)) {
				em_static_continue_create($data, "标签{$tag['tagname']}分页页面生成中。", $limit_start + $limit, '&before_tid='.$index);		
			} else {
				em_static_continue_create($data, "标签{$tag['tagname']}分页页面全部生成完毕。", 2, '&before_tid='.(++$index));
			}
		} else {
			em_static_go_to_next_step($data, '所有标签日志列表页面生成完毕');
		}		
	}
}

function em_static_create_author() {
	$data = em_static_get_data();
	$db = Mysql::getInstance();
	$em_static = EMStatic::get_instance();
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
	$before_uid = isset($_GET['before_uid']) ? intval($_GET['before_uid']) : 0;
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 2;
	$limit = $data['limits']['author_limit'];
	if (! isset($data['author_ids']) || empty($data['author_ids'])) {
		$where = 'uid > '.$before_uid;
		if ($uid)
			$where = 'uid = '.$uid;
		$sql = 'SELECT uid, username FROM '.DB_PREFIX.'user WHERE '.$where.' ORDER BY uid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$user = $db->fetch_array($query);
			if ($em_static->create_author_pages($user['uid'], $limit_start, $limit)) {
				em_static_continue_create($data, "用户{$user['username']}日志列表分页页面生成中", $limit_start + $limit, '&uid='.$user['uid']);		
			} else {
				em_static_continue_create($data, "用户{$user['username']}日志列表全部生成完毕", 2, '&before_uid='.$user['uid']);
			}
		} else {
			em_static_go_to_next_step($data, '所有用户日志列表页面生成完毕');
		}
	} else {
		$index = $before_uid ? intval($before_uid) : 0;
		if ( ! isset($data['author_ids'][$index])) {
			em_static_go_to_next_step($data, '所有标签日志列表页面生成完毕');
			return;
		}
		$where = ' uid = '.$data['author_ids'][$index];
		$sql = 'SELECT uid, username FROM '.DB_PREFIX.'user WHERE '.$where.' ORDER BY uid ASC LIMIT 1 ';
		$query = $db->query($sql);
		if ($db->num_rows($query) > 0) {
			$user = $db->fetch_array($query);
			if ($em_static->create_author_pages($user['uid'], $limit_start, $limit)) {
				em_static_continue_create($data, "用户{$user['username']}日志列表分页页面生成中", $limit_start + $limit, '&before_uid='.$index);		
			} else {
				em_static_continue_create($data, "用户{$user['username']}日志列表全部生成完毕", 2, '&before_uid='.++$index);
			}
		} else {
			em_static_go_to_next_step($data, '所有用户日志列表页面生成完毕');
		}		
	}
}

function em_static_create_record() {
	$data = em_static_get_data();
	$cache = Cache::getInstance();
	$index = isset($_GET['index']) ? intval($_GET['index']) : 0;
	$before_index = isset($_GET['before_index']) ? intval($_GET['before_index']) : 0;
	$limit_start = isset($_GET['limit_start']) ? intval($_GET['limit_start']) : 2;
	if ($index)
		$before_index = $index;
	$records = $cache->readCache('record');
	$limit = $data['limits']['record_limit'];
	if (isset($records[$before_index])) {
		$em_static = EMStatic::get_instance();
		if ($em_static->create_record_pages($records[$before_index]['date'], $records[$before_index]['lognum'], $limit_start, $limit)) {
			em_static_continue_create($data, "归档{$records[$before_index]['date']}日志列表分页页面生成中。", $limit_start + $limit, '&index='.$before_index);		
		} else {
			if (isset($data['record_date']) && $data['record_date'] == $records[$before_index]['date'])
				em_static_go_to_next_step($data, '所有用户日志列表页面生成完毕');
			else
				em_static_continue_create($data, "归档{$records[$before_index]['date']}日志列表全部生成完毕。", 2, '&before_index='.($before_index+1));
		}
	} else {
		em_static_go_to_next_step($data, '所有用户日志列表页面生成完毕');
	}		
}

function em_static_get_data() {
	if ( ! isset($_GET['data'])) 
		return '';
	$data = base64_decode($_GET['data']);
	$data = @unserialize($data);
	return $data;
}

function em_static_go_to_next_step($data, $msg, $extra_data = array()) {
	$next = array_pop($data['create_pages']);
	if ( $next ) {
		$msg .= '，页面自动生成中...请不要关闭浏览器。';
		if (function_exists('em_static_create_'.$next)) {
			em_static_msg($msg, '?do=create_'.$next.'&data='.base64_encode(serialize($data)).implode('&', $extra_data).(defined('EM_STATIC_DEBUG') ? '&XDEBUG_PROFILE' : ''));
		}		
	} else {
		$time = time() - $data['time_start'];
		$total_time = '<br>本次生成总耗时';
		if ($time < 60) {
			$total_time .= "[{$time}秒]。";
		} else {
			$minutes = intval($time / 60);
			$seconds = $time % 60;
			$total_time .= "[{$minutes}分{$seconds}秒]。";
		}
		$msg .= '，所有页面都已经生成完毕。'.$total_time;
		em_static_msg($msg, '', true);		
	}
}

function em_static_continue_create($data, $msg, $limit_start, $extra_data = '') {
	em_static_msg($msg, '?do='.$_GET['do']."&limit_start={$limit_start}{$extra_data}&data=".base64_encode(serialize($data)).(defined('EM_STATIC_DEBUG') ? '&XDEBUG_PROFILE' : ''));
}

function em_static_msg($msg, $url) {
?><!DOCTYPE html>
<html>
<head>
<?php if (!empty($url)) :?>
<meta http-equiv="refresh" content="1;url=<?php echo $url?>" />
<?php endif;?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<script>		
		parent.$('#em_static_msg').append('<?php echo $msg?><br>').animate({scrollTop: parent.$('#em_static_msg').prop("scrollHeight") - parent.$('#em_static_msg').height() }, "fast");
;
	</script>
</body>
</html>
	<?php
}