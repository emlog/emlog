<?php
/**
 * media
 * @package EMLOG (www.emlog.net)
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
	$medias = $Media_Model->getMedias($page, $perpage_count);
	$count = $Media_Model->getMediaCount();
	$pageurl = pagination($count, $perpage_count, $page, "media.php?page=");
	include View::getView('header');
	require_once(View::getView('media'));
	include View::getView('footer');
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

	$ret = uploadFileAjax($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size']);

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

	// 写入缩略图信息
	if (isset($ret['file_info']['thum_file'])) {
		$Media_Model->addMedia($ret['file_info'], $aid);
	}

	if ($editor) {
		echo json_encode($ret);
	} else {
		echo 'success';
	}
}

if ($action === 'delete') {
	LoginAuth::checkToken();
	$aid = isset($_GET['aid']) ? (int)$_GET['aid'] : '';
	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
	$attach = $DB->fetch_array($query);
	$logid = $attach['blogid'];
	if (file_exists($attach['filepath'])) {
		@unlink($attach['filepath']) or emMsg("删除失败!");
	}

	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = " . $attach['aid']);
	$thum_attach = $DB->fetch_array($query);
	if ($thum_attach) {
		if (file_exists($thum_attach['filepath'])) {
			@unlink($thum_attach['filepath']) or emMsg("删除失败!");
		}
		$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$thum_attach['aid']} ");
	}

	$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$attach['aid']} ");
	emDirect("media.php?active_del=1");
}
