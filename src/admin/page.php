<?php
/**
 * 页面管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$navibar = Option::get('navibar');

//加载页面管理页面
if ($action == '') {
	$emPage = new Log_Model();

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$pages = $emPage->getLogsForAdmin('', '', $page, 'page');
	$pageNum = $emPage->getLogNum('','','page', 1);

	$pageurl =  pagination($pageNum, Option::get('admin_perpage_num'), $page, "./page.php?page");

	include View::getView('header');
	require_once(View::getView('admin_page'));
	include View::getView('footer');
	View::output();
}
//显示新建页面表单
if ($action == 'new') {
	include View::getView('header');
	require_once(View::getView('add_page'));
	include View::getView('footer');
	View::output();
}
//显示编辑页面表单
if ($action == 'mod') {
	$emPage = new Log_Model();

	$pageId = isset($_GET['id']) ? intval($_GET['id']) : '';
	$pageData = $emPage->getOneLogForAdmin($pageId);
	extract($pageData);

	$pageUrl = isset($navibar[$pageId]['url']) ? $navibar[$pageId]['url'] : '' ;
	$is_blank = isset($navibar[$pageId]['is_blank']) ? $navibar[$pageId]['is_blank'] : '' ;

	if($allow_remark == 'y')
	{
		$ex = "checked=\"checked\"";
		$ex2 = '';
	}else{
		$ex = '';
		$ex2 = "checked=\"checked\"";
	}
	if($is_blank == '_blank'){
		$ex3 = "checked=\"checked\"";
		$ex4 = '';
	}else{
		$ex3 = '';
		$ex4 = "checked=\"checked\"";
	}

	include View::getView('header');
	require_once(View::getView('edit_page'));
	include View::getView('footer');
	View::output();
}
//保存页面
if ($action == 'add' || $action == 'edit' || $action == 'autosave') {
	$emPage = new Log_Model();

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$pageUrl = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$pageId = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//如被自动保存为草稿则有blog id号
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$is_blank = isset($_POST['is_blank']) ? addslashes($_POST['is_blank']) : '';
	$ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);

	$postTime = $emPage->postDate(Option::get('timezone'));

	$logData = array(
	'title'=>$title,
	'content'=>$content,
	'excerpt'=>'',
	'date'=>$postTime,
	'allow_remark'=>$allow_remark,
	'hide'=>$ishide,
	'type'=>'page'
	);

	if($pageId > 0)//自动保存后,添加变为更新
	{
		$emPage->updateLog($logData, $pageId);
	}else{
		$pageId = $emPage->addlog($logData);
	}

	if($pageUrl && !preg_match("/^http|ftp.+$/i", $pageUrl))
	{
		$pageUrl = 'http://'.$pageUrl;
	}

	$navibar[$pageId] = array('title' => stripslashes($title), 'url' => stripslashes($pageUrl), 'is_blank' => $is_blank, 'hide' => $ishide);
	$navibar = addslashes(serialize($navibar));
	Option::updateOption('navibar', $navibar);

	$CACHE->updateCache(array('logatts', 'options'));
	switch ($action)
	{
		case 'autosave':
			echo "autosave_gid:{$pageId}_df:0_";
			break;
		case 'add':
		case 'edit':
			$tbmsg = '';
			$ok_msg = $action == 'add' ? '页面发布成功！' : '页面保存成功！';
			$ok_url = 'page.php';
			formMsg($ok_msg,$ok_url, 1);
			break;
	}
}
//操作页面
if ($action == 'operate_page') {
	$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
	$pages = isset($_POST['page']) ? array_map('intval', $_POST['page']) : array();

	$emPage = new Log_Model();

	switch ($operate)
	{
		case 'del':
			foreach($pages as $value)
			{
				$emPage->deleteLog($value);
				unset($navibar[$value]);
			}
			$navibar = addslashes(serialize($navibar));
			Option::updateOption('navibar', $navibar);
			$CACHE->updateCache(array('logatts', 'options', 'sta', 'comment'));

			header("Location: ./page.php?active_del=true");
			break;
		case 'hide':
		case 'pub':
			$ishide = $operate == 'hide' ? 'y' : 'n';
			foreach($pages as $value)
			{
				$emPage->hideSwitch($value, $ishide);
				$navibar[$value]['hide'] = $ishide;
			}
			$navibar = addslashes(serialize($navibar));
			Option::updateOption('navibar', $navibar);
			$CACHE->updateCache(array('logatts', 'options', 'sta', 'comment'));
			header("Location: ./page.php?active_hide_".$ishide."=true");
			break;
	}
}
