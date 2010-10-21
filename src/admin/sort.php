<?php
/**
 * 分类管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$Sort_Model = new Sort_Model();

if($action == '')
{
	$sorts = $CACHE->readCache('sort');
	include View::getView('header');
	require_once View::getView('sort');
	include View::getView('footer');
	View::output();
}

if ($action == 'taxis')
{
	$sort = isset($_POST['sort']) ? $_POST['sort'] : '';
	if(!empty($sort))
	{
		foreach($sort as $key=>$value)
		{
			$value = intval($value);
			$key = intval($key);
			$Sort_Model->updateSort(array('taxis'=>$value), $key);
		}
		$CACHE->updateCache('sort');
		header("Location: ./sort.php?active_taxis=true");
	}else{
		header("Location: ./sort.php?error_b=true");
	}
}

if($action== 'add')
{
	$sortname = isset($_POST['sortname']) ? addslashes(trim($_POST['sortname'])) : '';
	if(empty($sortname))
	{
		header("Location: ./sort.php?error_a=true");
		exit;
	}
	$Sort_Model->addSort($sortname);
	$CACHE->updateCache('sort');
	header("Location: ./sort.php?active_add=true");
}

if($action == 'update')
{
	$sortname = isset($_GET['name']) ? addslashes(trim($_GET['name'])) : '';
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';

	$Sort_Model->updateSort(array('sortname'=>$sortname), $sid);
	$CACHE->updateCache(array('sort', 'logsort'));
	header("Location: ./sort.php?active_edit=true");
}

if ($action == 'del')
{
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
	$Sort_Model->deleteSort($sid);
	$CACHE->updateCache(array('sort', 'logsort'));
	header("Location: ./sort.php?active_del=true");
}
