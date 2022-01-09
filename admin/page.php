<?php
/**
 * page
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
	$emPage = new Log_Model();

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

	$pages = $emPage->getLogsForAdmin('', '', $page, 'page');
	$pageNum = $emPage->getLogNum('', '', 'page', 1);

	$pageurl = pagination($pageNum, Option::get('admin_perpage_num'), $page, "./pages.php?page=");

	include View::getAdmView('header');
	require_once(View::getAdmView('page'));
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'new') {
	$pageData = array(
/*vot*/ 	'containertitle'  => lang('add_page'),
		'pageId'          => -1,
		'title'           => '',
		'content'         => '',
		'alias'           => '',
		'hide'            => '',
		'template'        => 'page',
		'is_allow_remark' => 'n',
		'att_frame_url'   => 'attachment.php?action=selectFile',
	);
	extract($pageData);

	//media
	$Media_Model = new Media_Model();
	$medias = $Media_Model->getMedias();

	include View::getAdmView('header');
	require_once(View::getAdmView('page_create'));
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'mod') {
	$emPage = new Log_Model();

/*vot*/	$containertitle = lang('page_edit');
	$pageId = isset($_GET['id']) ? (int)$_GET['id'] : '';
	$pageData = $emPage->getOneLogForAdmin($pageId);
	extract($pageData);

	//media
	$Media_Model = new Media_Model();
	$medias = $Media_Model->getMedias();

	$is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';

	include View::getAdmView('header');
	require_once(View::getAdmView('page_create'));
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'save') {
	$emPage = new Log_Model();
	$Navi_Model = new Navi_Model();

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$content = isset($_POST['pagecontent']) ? addslashes(trim($_POST['pagecontent'])) : '';
	$alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
	$pageId = isset($_POST['pageid']) ? (int)trim($_POST['pageid']) : -1;
	$ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);
	$template = isset($_POST['template']) && $_POST['template'] != 'page' ? addslashes(trim($_POST['template'])) : '';
	$allow_remark = isset($_POST['allow_remark']) ? addslashes(trim($_POST['allow_remark'])) : 'n';

	LoginAuth::checkToken();

	$postTime = time();

	if (!empty($alias)) {
		$logalias_cache = $CACHE->readCache('logalias');
		$alias = $emPage->checkAlias($alias, $logalias_cache, $pageId);
	}

	$logData = array(
		'title'        => $title,
		'content'      => $content,
		'excerpt'      => '',
		'date'         => $postTime,
		'allow_remark' => $allow_remark,
		'hide'         => $ishide,
		'alias'        => $alias,
		'type'         => 'page',
		'template'     => $template,
	);

	$directUrl = '';
	if ($pageId > 0) {
		$emPage->updateLog($logData, $pageId);
		$directUrl = './page.php?active_pubpage=1';
	} else {
		$pageId = $emPage->addlog($logData);
		$directUrl = './page.php?active_hide_n=1';
	}

	$CACHE->updateCache(array('options', 'logalias'));

	switch ($action) {
		case 'autosave':
			echo "autosave_gid:{$pageId}_df:0_";
			break;
		case 'save':
			emDirect($directUrl);
			break;
	}
}

if ($action == 'operate_page') {
	$operate = $_POST['operate'] ?? '';
	$pages = isset($_POST['page']) ? array_map('intval', $_POST['page']) : array();

	LoginAuth::checkToken();

	$emPage = new Log_Model();

	switch ($operate) {
		case 'del':
			foreach ($pages as $value) {
				$emPage->deleteLog($value);
				unset($navibar[$value]);
			}
			$navibar = addslashes(serialize($navibar));
			Option::updateOption('navibar', $navibar);
			$CACHE->updateCache(array('options', 'sta', 'comment', 'logalias'));

			emDirect("./page.php?active_del=1");
			break;
		case 'hide':
		case 'pub':
			$ishide = $operate == 'hide' ? 'y' : 'n';
			foreach ($pages as $value) {
				$emPage->hideSwitch($value, $ishide);
				$navibar[$value]['hide'] = $ishide;
			}
			$navibar = addslashes(serialize($navibar));
			Option::updateOption('navibar', $navibar);
			$CACHE->updateCache(array('options', 'sta', 'comment'));
			emDirect("./page.php?active_hide_" . $ishide . "=1");
			break;
	}
}
