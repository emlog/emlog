<?php
/**
 * media
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$DB = Database::getInstance();

$Media_Model = new Media_Model();

if (empty($action)) {
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perpage_count = 24;
	$medias = $Media_Model->getMedias($page, $perpage_count, User::isAdmin() ? null : UID);
	$count = $Media_Model->getMediaCount();
	$pageurl = pagination($count, $perpage_count, $page, "media.php?page=");
	include View::getAdmView('header');
	require_once(View::getAdmView('media'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'lib') {
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perpage_count = 48;
	$medias = $Media_Model->getMedias($page, $perpage_count);
	$count = $Media_Model->getMediaCount();
	$pageurl = pagination($count, $perpage_count, $page, "media.php?page=");
	require_once(View::getAdmView('media_lib'));
	View::output();
}

if ($action === 'upload') {
	$editor = isset($_GET['editor']) ? 1 : 0; // 是否来自Markdown编辑器的上传
	$attach = $_FILES['file'] ?? '';
	if ($editor) {
		$attach = $_FILES['editormd-image-file'] ?? '';
	}

	if (!$attach || $attach['error'] === 4) {
		if ($editor) {
			echo json_encode(['success' => 0, 'message' => 'upload error']);
		} else {
			header("HTTP/1.0 400 Bad Request");
			echo "upload error";
		}
		exit;
	}

	$ret = '';

	addAction('upload_media', 'upload2local');
	doOnceAction('upload_media', $attach, $ret);

	if (empty($ret['success'])) {
		if ($editor) {
			echo json_encode($ret);
		} else {
			header("HTTP/1.0 400 Bad Request");
			echo $ret['message'];
		}
		exit;
	}

	// 写入资源信息
	$aid = $Media_Model->addMedia($ret['file_info']);
	if ($editor) {
		echo json_encode($ret);
	} else {
		echo 'success';
	}
}

if ($action === 'delete') {
	LoginAuth::checkToken();
	$aid = isset($_GET['aid']) ? (int)$_GET['aid'] : '';
	$Media_Model->deleteMedia($aid);
	emDirect("media.php?active_del=1");
}

if ($action == 'operate_media') {
	$operate = $_POST['operate'] ?? '';
	$aids = isset($_POST['aids']) ? array_map('intval', $_POST['aids']) : array();

	LoginAuth::checkToken();
	switch ($operate) {
		case 'del':
			foreach ($aids as $value) {
				$Media_Model->deleteMedia($value);
			}
			emDirect("media.php?active_del=1");
			break;
	}
}
