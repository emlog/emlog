<?php
/**
 * 链接管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Navi_Model = new Navi_Model();

if($action == '')
{
	$navis = $Navi_Model->getNavis();
	include View::getView('header');
	require_once(View::getView('navbar'));
	include View::getView('footer');
	View::output();
}

if ($action== 'taxis')
{
	$navi = isset($_POST['navi']) ? $_POST['navi'] : '';
	if(!empty($navi))
	{
		foreach($navi as $key=>$value)
		{
			$value = intval($value);
			$key = intval($key);
			$Navi_Model->updateNavi(array('taxis'=>$value), $key);
		}
		$CACHE->updateCache('navi');
		emDirect("./navbar.php?active_taxis=true");
	}else {
		emDirect("./navbar.php?error_b=true");
	}
}

if($action== 'add')
{
	$taxis = isset($_POST['taxis']) ? intval(trim($_POST['taxis'])) : 0;
	$naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
	$url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : 'n';

	if($naviname =='' || $url =='')
	{
		emDirect("./navbar.php?error_a=true");
	}
	if(!preg_match("/^http|ftp.+$/i", $url))
	{
		$url = 'http://'.$url;
	}
	$Navi_Model->addNavi($naviname, $url, $description, $taxis, $newtab);
	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_add=true");
}

if ($action== 'mod')
{
	$naviId = isset($_GET['navid']) ? intval($_GET['navid']) : '';

	$naviData = $Navi_Model->getOneNavi($naviId);
	extract($naviData);

	$conf_newtab = $newtab == 'y' ? 'checked="checked"' : '';

	include View::getView('header');
	require_once(View::getView('naviedit'));
	include View::getView('footer');View::output();
}

if($action=='update')
{
	$naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
	$url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : '';
	$naviId = isset($_POST['navid']) ? intval($_POST['navid']) : '';

	if(!preg_match("/^http|ftp.+$/i", $url))
	{
		$url = 'http://'.$url;
	}

	$Navi_Model->updateNavi(array('naviname'=>$naviname, 'url'=>$url, 'description'=>$description, 'newtab'=>$newtab), $naviId);

	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_edit=true");
}

if ($action == 'del')
{
	$navid = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Navi_Model->deleteNavi($navid);
	$CACHE->updateCache('navi');
	emDirect("./navbar.php?active_del=true");
}

if($action == 'hide')
{
	$naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

	$Navi_Model->updateNavi(array('hide'=>'y'), $naviId);

	$CACHE->updateCache('navi');
	emDirect('./navbar.php');
}

if($action == 'show')
{
	$naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

	$Navi_Model->updateNavi(array('hide'=>'n'), $naviId);

	$CACHE->updateCache('navi');
	emDirect('./navbar.php');
}
