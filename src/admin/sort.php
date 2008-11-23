<?php
/**
 * 分类管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_sort.php');

$emSort = new emSort($DB);

if($action == '')
{
	$sorts = $emSort->getSorts();
	include getViews('header');
	require_once(getViews('sort'));
	include getViews('footer');
	cleanPage();
}

if ($action == 'taxis')
{
	$sort = isset($_POST['sort']) ? $_POST['sort'] : '';
	if(!empty($sort))
	{
		foreach($sort as $key=>$value)
		{
			$value = intval($value);
			$emSort->updateSort(array('taxis'=>$value), $key);
		}
		$CACHE->mc_sort();
		header("Location: ./sort.php?active_taxis=true");
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
	$emSort->addSort($sortname);
	$CACHE->mc_sort();
	header("Location: ./sort.php?active_add=true");
}

if($action == 'update')
{
	$sortname = isset($_GET['name']) ? addslashes(trim($_GET['name'])) : '';
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';

	$emSort->updateSort(array('sortname'=>$sortname), $sid);
	$CACHE->mc_sort();
	$CACHE->mc_logsort();
	header("Location: ./sort.php?active_edit=true");
}

if ($action == 'del')
{
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
	$emSort->deleteSort($sid);
	$CACHE->mc_sort();
	$CACHE->mc_logsort();
	header("Location: ./sort.php?active_del=true");
}

?>