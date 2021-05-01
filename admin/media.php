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
	$medias = $Media_Model->getMedias($page);
	$count = $Media_Model->getMediaCount();
	$pageurl = pagination($count, 30, $page, "media.php?page=");
	include View::getView('header');
	require_once(View::getView('media'));
	include View::getView('footer');
	View::output();
}

if ($action === 'upload_multi') {
	$logid = isset($_GET['logid']) ? (int)$_GET['logid'] : 0;
	$attach = $_FILES['file'] ?? '';

	if (!$attach || $attach['error'] == 4) {
		return;
	}

	$isthumbnail = Option::get('isthumbnail') === 'y';
	$attach['name'] = Database::getInstance()->escape_string($attach['name']);
	$file_info = uploadFileBySwf($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], Option::getAttType(), false, $isthumbnail);

	// 写入附件信息
	$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s',0)";
	$query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
	$DB->query($query);
	$aid = $DB->insert_id();

	// 写入缩略图信息
	if (isset($file_info['thum_file'])) {
		$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')";
		$query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type'], $aid);
		$DB->query($query);
	}
}

//删除附件
if ($action === 'delete') {
	LoginAuth::checkToken();
	$aid = isset($_GET['aid']) ? (int)$_GET['aid'] : '';
	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
	$attach = $DB->fetch_array($query);
	$logid = $attach['blogid'];
	if (file_exists($attach['filepath'])) {
		@unlink($attach['filepath']) or emMsg("删除附件失败!");
	}

	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = " . $attach['aid']);
	$thum_attach = $DB->fetch_array($query);
	if ($thum_attach) {
		if (file_exists($thum_attach['filepath'])) {
			@unlink($thum_attach['filepath']) or emMsg("删除附件失败!");
		}
		$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$thum_attach['aid']} ");
	}

	$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$attach['aid']} ");
	emDirect("media.php?active_del=1");
}
