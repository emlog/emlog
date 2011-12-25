<?php
/**
 * 分类管理
 * @copyright (c) Emlog All Rights Reserved
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
		emDirect("./sort.php?active_taxis=true");
	}else{
		emDirect("./sort.php?error_b=true");
	}
}

if($action== 'add')
{
	$taxis = isset($_POST['taxis']) ? intval(trim($_POST['taxis'])) : 0;
	$sortname = isset($_POST['sortname']) ? addslashes(trim($_POST['sortname'])) : '';
	$alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';

	if(empty($sortname)){
		emDirect("./sort.php?error_a=true");
	}
	if (!empty($alias)) {
		if (!preg_match("|^[\w-]+$|", $alias)) {
			emDirect("./sort.php?error_c=true");
		}elseif(preg_match("|^[0-9]+$|", $alias)){
			emDirect("./sort.php?error_f=true");
		}elseif (in_array($alias, array('post','record','sort','tag','author','page'))) {
			emDirect("./sort.php?error_e=true");
		}else {
		    $sort_cache = $CACHE->readCache('sort');
		    foreach ($sort_cache as $key => $value) {
		        if ($alias == $value['alias']) {
					emDirect("./sort.php?error_d=true");
		        }
		    }
		}
	}

	$Sort_Model->addSort($sortname, $alias, $taxis);
	$CACHE->updateCache('sort');
	emDirect("./sort.php?active_add=true");
}

if($action == 'update')
{
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';

	$sort_data = array();
	if (isset($_GET['name'])) {
		$sort_data['sortname'] = addslashes(trim($_GET['name']));
	}
	if (isset($_GET['alias'])) {
		$sort_data['alias'] = addslashes(trim($_GET['alias']));
		if (!empty($sort_data['alias'])) {
			if (!preg_match("|^[\w-]+$|", $sort_data['alias'])) {
				emDirect("./sort.php?error_c=true");
			} elseif(preg_match("|^[0-9]+$|", $sort_data['alias'])){
				emDirect("./sort.php?error_f=true");
			} elseif (in_array($sort_data['alias'], array('post','record','sort','tag','author','page'))) {
				emDirect("./sort.php?error_e=true");
			} else{
			    $sort_cache = $CACHE->readCache('sort');
			    foreach ($sort_cache as $key => $value) {
			    	if ($sort_data['alias'] == $value['alias']) {
			    		emDirect("./sort.php?error_d=true");
			    	}
			    }
			}
        }
    }

	$Sort_Model->updateSort($sort_data, $sid);
	$CACHE->updateCache(array('sort', 'logsort'));
	emDirect("./sort.php?active_edit=true");
}

if ($action == 'del')
{
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
	$Sort_Model->deleteSort($sid);
	$CACHE->updateCache(array('sort', 'logsort'));
	emDirect("./sort.php?active_del=true");
}
