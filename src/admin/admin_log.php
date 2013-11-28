<?php
/**
 * 管理文章
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Log_Model = new Log_Model();

//显示文章(草稿)管理页面
if ($action == '') {
	$Tag_Model = new Tag_Model();
	$User_Model = new User_Model();

	$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
	$tagId = isset($_GET['tagid']) ? intval($_GET['tagid']) : '';
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes($_GET['keyword']) : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $checked = isset($_GET['checked']) ? addslashes($_GET['checked']) : '';

	$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ?  'DESC' : 'ASC';
	$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ?  'DESC' : 'ASC';
	$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ?  'ASC' : 'DESC';

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
		$sqlSegment .= 'top DESC,date DESC';
	}

	$hide_state = $pid ? 'y' : 'n';
	if ($pid == 'draft') {
		$hide_stae = 'y';
		$sorturl = '&pid=draft';
		$pwd = '草稿箱';
	} else{
		$hide_stae = 'n';
		$sorturl = '';
		$pwd = '文章管理';
	}

	$logNum = $Log_Model->getLogNum($hide_state, $sqlSegment, 'blog', 1);
	$logs = $Log_Model->getLogsForAdmin($sqlSegment, $hide_state, $page);
	$sorts = $CACHE->readCache('sort');
	$log_cache_tags = $CACHE->readCache('logtags');
	$tags = $Tag_Model->getTag();

	$subPage = '';
	foreach ($_GET as $key=>$val) {
		$subPage .= $key != 'page' ? "&$key=$val" : '';
	}
	$pageurl =  pagination($logNum, Option::get('admin_perpage_num'), $page, "admin_log.php?{$subPage}&page=");

	include View::getView('header');
	require_once View::getView('admin_log');
	include View::getView('footer');View::output();
}

//操作文章
if ($action == 'operate_log') {
	$operate = isset($_REQUEST['operate']) ? $_REQUEST['operate'] : '';
	$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
	$logs = isset($_POST['blog']) ? array_map('intval', $_POST['blog']) : array();
	$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
	$author = isset($_POST['author']) ? intval($_POST['author']) : '';
    $gid = isset($_GET['gid']) ? intval($_GET['gid']) : '';

	if ($operate == '') {
		emDirect("./admin_log.php?pid=$pid&error_b=1");
	}
	if (empty($logs) && empty($gid)) {
		emDirect("./admin_log.php?pid=$pid&error_a=1");
	}

	switch ($operate) {
		case 'del':
			foreach ($logs as $val)
			{
				doAction('before_del_log', $val);
				$Log_Model->deleteLog($val);
				doAction('del_log', $val);
			}
			$CACHE->updateCache();
			if ($pid == 'draft')
			{
				emDirect("./admin_log.php?pid=draft&active_del=1");
			} else{
				emDirect("./admin_log.php?active_del=1");
			}
			break;
		case 'top':
			foreach ($logs as $val)
			{
				$Log_Model->updateLog(array('top'=>'y'), $val);
			}
			emDirect("./admin_log.php?active_up=1");
			break;
		case 'notop':
			foreach ($logs as $val)
			{
				$Log_Model->updateLog(array('top'=>'n'), $val);
			}
			emDirect("./admin_log.php?active_down=1");
			break;
		case 'hide':
			foreach ($logs as $val)
			{
				$Log_Model->hideSwitch($val, 'y');
			}
			$CACHE->updateCache();
			emDirect("./admin_log.php?active_hide=1");
			break;
		case 'pub':
			foreach ($logs as $val)
			{
				$Log_Model->hideSwitch($val, 'n');
                if (ROLE == ROLE_ADMIN)
                {
                    $Log_Model->checkSwitch($val, 'y');
                }
			}
			$CACHE->updateCache();
			emDirect("./admin_log.php?pid=draft&active_post=1");
			break;
		case 'move':
			foreach ($logs as $val)
			{
				$Log_Model->updateLog(array('sortid'=>$sort), $val);
			}
			$CACHE->updateCache(array('sort', 'logsort'));
			emDirect("./admin_log.php?active_move=1");
			break;
		case 'change_author':
			if (ROLE != ROLE_ADMIN)
			{
				emMsg('权限不足！','./');
			}
			foreach ($logs as $val)
			{
				$Log_Model->updateLog(array('author'=>$author), $val);
			}
			$CACHE->updateCache('sta');
			emDirect("./admin_log.php?active_change_author=1");
			break;
        case 'check':
            if (ROLE != ROLE_ADMIN)
			{
				emMsg('权限不足！','./');
			}
			$Log_Model->checkSwitch($gid, 'y');
			$CACHE->updateCache();
			emDirect("./admin_log.php?active_ck=1");
			break;
        case 'uncheck':
            if (ROLE != ROLE_ADMIN)
			{
				emMsg('权限不足！','./');
			}
			$Log_Model->checkSwitch($gid, 'n');
			$CACHE->updateCache();
			emDirect("./admin_log.php?active_unck=1");
			break;
	}
}
