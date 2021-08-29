<?php
/**
 * The article management
 *
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();
$Sort_Model = new Sort_Model();
$User_Model = new User_Model();

if (empty($action)) {
	$draft = isset($_GET['draft']) ? 1 : 0;
	$tagId = isset($_GET['tagid']) ? (int)$_GET['tagid'] : '';
	$sid = isset($_GET['sid']) ? (int)$_GET['sid'] : '';
	$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';
	$keyword = isset($_GET['keyword']) ? addslashes($_GET['keyword']) : '';
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$checked = isset($_GET['checked']) ? addslashes($_GET['checked']) : '';

	$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ? 'DESC' : 'ASC';
	$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ? 'DESC' : 'ASC';
	$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ? 'ASC' : 'DESC';

	$sqlSegment = '';
	if ($tagId) {
		$blogIdStr = $Tag_Model->getTagById($tagId);
		$sqlSegment = "and gid IN ($blogIdStr)";
	} elseif ($sid) {
		$sqlSegment = "and sortid=$sid";
	} elseif ($uid) {
		$sqlSegment = "and author=$uid";
	} elseif ($checked) {
		$sqlSegment = "and checked='$checked'";
	} elseif ($keyword) {
		$sqlSegment = "and title like '%$keyword%'";
	}
	$sqlSegment .= ' ORDER BY ';
	if (isset($_GET['sortView'])) {
		$sqlSegment .= "views $sortView";
	} elseif (isset($_GET['sortComm'])) {
		$sqlSegment .= "comnum $sortComm";
	} elseif (isset($_GET['sortDate'])) {
		$sqlSegment .= "date $sortDate";
	} else {
		$sqlSegment .= 'top DESC, sortop DESC, date DESC';
	}

	$hide_state = $draft ? 'y' : 'n';
	if ($draft) {
		$hide_stae = 'y';
		$sorturl = '&draft=1';
	} else {
		$hide_stae = 'n';
		$sorturl = '';
	}

	$logNum = $Log_Model->getLogNum($hide_state, $sqlSegment, 'blog', 1);
	$logs = $Log_Model->getLogsForAdmin($sqlSegment, $hide_state, $page);
	$sorts = $CACHE->readCache('sort');
	$log_cache_tags = $CACHE->readCache('logtags');

	$subPage = '';
	foreach ($_GET as $key => $val) {
		$subPage .= $key != 'page' ? "&$key=$val" : '';
	}
	$pageurl = pagination($logNum, Option::get('admin_perpage_num'), $page, "article.php?{$subPage}&page=");

	include View::getView('header');
	require_once View::getView('article');
	include View::getView('footer');
	View::output();
}

if ($action == 'operate_log') {
	$operate = $_REQUEST['operate'] ?? '';
	$draft = isset($_POST['draft']) ? (int)$_POST['draft'] : 0;
	$logs = isset($_POST['blog']) ? array_map('intval', $_POST['blog']) : array();
	$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : '';
	$author = isset($_POST['author']) ? (int)$_POST['author'] : '';
	$gid = isset($_GET['gid']) ? (int)$_GET['gid'] : '';

	LoginAuth::checkToken();

	if ($operate == '') {
		emDirect("./article.php?draft=$draft&error_b=1");
	}
	if (empty($logs) && empty($gid)) {
		emDirect("./article.php?draft=$draft&error_a=1");
	}

	switch ($operate) {
		case 'del':
			foreach ($logs as $val) {
				doAction('before_del_log', $val);
				$Log_Model->deleteLog($val);
				doAction('del_log', $val);
			}
			$CACHE->updateCache();
			if ($draft) {
				emDirect("./article.php?draft=1&active_del=1");
			} else {
				emDirect("./article.php?active_del=1");
			}
			break;
		case 'top':
			foreach ($logs as $val) {
				$Log_Model->updateLog(array('top' => 'y'), $val);
			}
			emDirect("./article.php?active_up=1");
			break;
		case 'sortop':
			foreach ($logs as $val) {
				$Log_Model->updateLog(array('sortop' => 'y'), $val);
			}
			emDirect("./article.php?active_up=1");
			break;
		case 'notop':
			foreach ($logs as $val) {
				$Log_Model->updateLog(array('top' => 'n', 'sortop' => 'n'), $val);
			}
			emDirect("./article.php?active_down=1");
			break;
		case 'hide':
			foreach ($logs as $val) {
				$Log_Model->hideSwitch($val, 'y');
			}
			$CACHE->updateCache();
			emDirect("./article.php?active_hide=1");
			break;
		case 'pub':
			foreach ($logs as $val) {
				$Log_Model->hideSwitch($val, 'n');
				if (ROLE == ROLE_ADMIN) {
					$Log_Model->checkSwitch($val, 'y');
				}
			}
			$CACHE->updateCache();
			emDirect("./article.php?draft=1&active_post=1");
			break;
		case 'move':
			foreach ($logs as $val) {
				$Log_Model->updateLog(array('sortid' => $sort), $val);
			}
			$CACHE->updateCache(array('sort', 'logsort'));
			emDirect("./article.php?active_move=1");
			break;
		case 'change_author':
			if (ROLE != ROLE_ADMIN) {
/*vot*/			emMsg(lang('no_permission'), './');
			}
			foreach ($logs as $val) {
				$Log_Model->updateLog(array('author' => $author), $val);
			}
			$CACHE->updateCache('sta');
			emDirect("./article.php?active_change_author=1");
			break;
		case 'check':
			if (ROLE != ROLE_ADMIN) {
/*vot*/			emMsg(lang('no_permission'), './');
			}
			$Log_Model->checkSwitch($gid, 'y');
			$CACHE->updateCache();
			emDirect("./article.php?active_ck=1");
			break;
		case 'uncheck':
			if (ROLE != ROLE_ADMIN) {
/*vot*/			emMsg(lang('no_permission'), './');
			}
			$Log_Model->checkSwitch($gid, 'n');
			$CACHE->updateCache();
			emDirect("./article.php?active_unck=1");
			break;
	}
}

//write article page
if ($action === 'write') {
	$blogData = [
		'logid'    => -1,
		'title'    => '',
		'content'  => '',
		'excerpt'  => '',
		'alias'    => '',
		'author'   => '',
		'sortid'   => -1,
		'type'     => 'blog',
		'password' => '',
		'hide'     => '',
		'author'   => UID,
		'cover'    => '',
	];

	extract($blogData);

	$isdraft = false;
/*vot*/	$containertitle = lang('post_write');
	$orig_date = '';
	$sorts = $CACHE->readCache('sort');
	$tagStr = '';
	$is_top = '';
	$is_sortop = '';
	$is_allow_remark = 'checked="checked"';
	$postDate = date('Y-m-d H:i:s');

	//media
	$Media_Model = new Media_Model();
	$medias = $Media_Model->getMedias();

	if (!ISREG && $sta_cache['lognum'] > 20) {
		emDirect("register.php?error_article=1");
	}

	include View::getView('header');
	require_once View::getView('article_write');
	include View::getView('footer');
	View::output();
}

// edit article page
if ($action === 'edit') {
	$logid = isset($_GET['gid']) ? (int)$_GET['gid'] : '';
	$blogData = $Log_Model->getOneLogForAdmin($logid);
	extract($blogData);

	$isdraft = $hide == 'y' ? true : false;
/*vot*/	$containertitle = $isdraft ? lang('draft_edit') : lang('post_edit');
	$postDate = date('Y-m-d H:i:s', $date);
	$sorts = $CACHE->readCache('sort');

	//tag
	$tags = array();
	foreach ($Tag_Model->getTag($logid) as $val) {
		$tags[] = $val['tagname'];
	}
	$tagStr = implode(',', $tags);

	//media
	$Media_Model = new Media_Model();
	$medias = $Media_Model->getMedias();

	$is_top = $top == 'y' ? 'checked="checked"' : '';
	$is_sortop = $sortop == 'y' ? 'checked="checked"' : '';
	$is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';

	include View::getView('header');
	require_once View::getView('article_write');
	include View::getView('footer');
	View::output();
}

if ($action == 'upload_cover') {
	$data = isset($_POST['image']) ? addslashes($_POST['image']) : '';
	//data:image/png;base64,xxxx
	$image_array = explode(",", $data);
	if (empty($image_array[1])) {
		exit("error");
	}
	$data = base64_decode($image_array[1]);
	$fname = Option::UPLOADFILE_PATH . gmdate('Ym') . '/' . time() . '.png';
	file_put_contents($fname, $data);
	echo $fname;
}
